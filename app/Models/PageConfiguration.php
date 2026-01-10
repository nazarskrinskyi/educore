<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'section_key',
        'content',
        'order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get configurations for a specific page
     */
    public static function getPageConfig(string $pageName): array
    {
        return self::where('page_name', $pageName)
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->keyBy('section_key')
            ->map(fn($config) => $config->content)
            ->toArray();
    }

    /**
     * Update or create a page configuration
     */
    public static function updateConfig(string $pageName, string $sectionKey, array $content, int $order = 0): self
    {
        return self::updateOrCreate(
            [
                'page_name' => $pageName,
                'section_key' => $sectionKey,
            ],
            [
                'content' => $content,
                'order' => $order,
                'is_active' => true,
            ]
        );
    }
}
