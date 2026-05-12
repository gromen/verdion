@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class('oferta oferta--single'))>
      <div class="oferta__content">
        @php(the_content())
      </div>
    </article>
  @endwhile
@endsection
