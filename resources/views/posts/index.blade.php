@extends('layouts.app')

@section('title', 'آخر الأخبار')
@push('css')
    <link rel="stylesheet" href="{{ asset('css') }}/posts.css">
    <style>
        .post-card .card-title {
            text-align: right;
            padding: 0;
        }
        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .category-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            background: #fff;
            color: #1e272e;
            border: 1px solid #e0e0e0;
        }
        .category-tab:hover {
            border-color: #daa520;
            color: #daa520;
            transform: translateY(-2px);
        }
        .category-tab.active {
            background: #1e272e;
            color: #daa520;
            border-color: #1e272e;
        }
        .category-tab .count {
            background: rgba(0,0,0,0.08);
            padding: 1px 8px;
            border-radius: 50px;
            font-size: 0.75rem;
        }
        .category-tab.active .count {
            background: rgba(218,165,32,0.2);
            color: #daa520;
        }
    </style>
@endpush
@section('content')
    <header class="page-header" style="background-image: url('{{ asset('images/bg/news.jpg') }}');">
        <div class="container text-center">
            <h1>آخر الأخبار والمقالات</h1>
            <p>تابع آخر المستجدات والفعاليات والأخبار الرسمية لمحافظة كفر الشيخ</p>
        </div>
    </header>
    <main class="main-content bg-light">
        <div class="container py-5">
            <div class="category-tabs">
                <a href="{{ route('posts.index') }}" class="category-tab {{ !$activeCategory ? 'active' : '' }}">الكل</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('posts.index', ['category' => $cat->slug]) }}" class="category-tab {{ $activeCategory === $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                        <span class="count">{{ $cat->posts_count }}</span>
                    </a>
                @endforeach
            </div>
            @if ($posts->isNotEmpty())
                <div class="row g-4">
                    @foreach ($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <div class="post-card">
                                <a href="{{ route('posts.show', $post->slug) }}" class="card-image-link">
                                    <div class="card-image">
                                        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}">
                                    </div>
                                </a>
                                <div class="card-content">
                                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}" class="card-category">{{ $post->category->name ?? 'غير مصنف' }}</a>
                                    <h3 class="card-title">
                                        <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    <p class="card-excerpt">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}
                                    </p>
                                    <div class="card-meta">
                                        <span class="meta-date">{{ $post->published_at->translatedFormat('d F, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="pagination-wrapper mt-5">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="h5">عذرًا، لا توجد أخبار لعرضها حاليًا.</p>
                </div>
            @endif

        </div>
    </main>
@endsection
