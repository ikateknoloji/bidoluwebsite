<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('tags')->paginate(9);
        return response()->json($projects);
    }


    public function store(Request $request)
    {
        // Validator ile manuel validasyon yap
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|file|image',
            'image_alt_text' => 'required|string',
            'image_caption' => 'required|string',
            'redirect_url' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'integer|exists:tags,id',
        ]);
    
        // Validasyon başarısız olursa hata mesajlarını döndür
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Validasyonu geçmiş verileri al
        $validatedData = $validator->validated();
    
        // Türkçe karakterleri İngilizce'ye dönüştür ve boşlukları alt tire ile değiştir
        $validatedData['name'] = Str::slug($validatedData['name'], '_');
    
        $validatedData['image_width'] = 300;
        $validatedData['image_height'] = 252;
    
        // Resmi storage'a yükle ve URL'yi oluştur
        $imagePath = $request->file('image')->storeAs(
            'images', 
            $validatedData['name'] . '.' . $request->file('image')->extension(),
            'public'
        );
    
        $validatedData['image_url'] = '/storage/' . $imagePath;
    
        // Project oluştur
        $project = Project::create($validatedData);
    
        // İlk etiketi otomatik olarak ekle
        $validatedData['tags'][] = Tag::first()->id;
        $project->tags()->attach($validatedData['tags']);
    
        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'required|string',
            'image_alt_text' => 'required|string',
            'image_caption' => 'required|string',
            'redirect_url' => 'required|string',
        ]);

        $validatedData['image_width'] = 300;
        $validatedData['image_height'] = 252;

        $project = Project::findOrFail($id);
        $project->update($validatedData);
        return response()->json($project);
    }


    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(null, 204);
    }

    public function getProjectsByTag($tagId)
    {
        $projects = Project::whereHas('tags', function ($query) use ($tagId) {
            $query->where('tag_id', $tagId);
        })->paginate(9);
        return response()->json($projects);
    }

    public function getAllTags()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

}