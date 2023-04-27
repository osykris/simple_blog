@extends('layouts.app-guest')
@section('content')
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Test Membuat Simple Blog</h4>
                            <h2>PT. Max Solution Indonesia</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="all-blog-posts">
                        <div class="row">
                            @foreach ($article as $articles)
                                <div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="down-content">
                                            <a href="{{ url('blog/detail') }}/{{ $articles->id }}">
                                                <h4>{{ $articles->title }}</h4>
                                            </a>
                                            <ul class="post-info">
                                                <li><a href="#">{{ $articles->author_name }}</a></li>
                                                <li><a href="#">{{ $articles->created_at->format('Y-m-d') }}</a></li>
                                                <?php $jumlah = ('App\Models\Comment')
                                                    ::join('articles', 'comments.article_id', '=', 'articles.id')
                                                    ->where('articles.id', $articles->id)
                                                    ->count(); ?>
                                                <li><a href="#">{{ $jumlah }} Comments</a></li>
                                            </ul>
                                            <p>{{ substr($articles->content, 0, 200) }}<a
                                                    href="{{ url('blog/detail') }}/{{ $articles->id }}"> Read More ... </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-lg-12" style="text-align: center;">
                                {{ $article->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
