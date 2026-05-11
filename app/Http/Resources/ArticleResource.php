<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->article_id,
            'slug' => $this->slug,
            'title' => $this->title,
            'photo' => $this->photo,
            'content_preview' => str($this->content)->limit(150),
            'full_content' => $this->content,
            'thumbnail' => $this->photo
                ? asset('storage/' . $this->photo)
                : asset('images/default.jpg'),

            'status' => [
                'label' => ucfirst($this->status),
                'value' => $this->status,
            ],
            'metrics' => [
                'views' => $this->views,
                'reading_time' => ceil(str_word_count($this->content) / 200) . ' min read', // Estimate 200 wpm reading speed
            ],

            'author' => [
                'name' => $this->author->name,
                'email' => $this->author->email,
            ],

            'is_edited' => $this->created_at->ne($this->updated_at),

            'timestamps' => [
                'created_at' => $this->created_at->diffForHumans(),
                'published_at' => $this->publish_date ? $this->publish_date->translatedFormat('d F Y H:i') : null,
                'last_update' => $this->updated_at->translatedFormat('l, d F Y H:i'),
                'status_label' => $this->created_at->ne($this->updated_at) ? 'Edited' : 'Original',
            ],
        ];
    }
}
