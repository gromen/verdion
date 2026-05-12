@extends('layouts.app')

@section('content')

  {{-- Hero header --}}
  <div class="ofertaArchive__hero">
    <div class="container-content ofertaArchive__heroInner">
      <p class="ofertaArchive__heroLabel">OFERTA</p>
      <h1 class="ofertaArchive__heroTitle">Nasze usługi</h1>
      <p class="ofertaArchive__heroDesc">
        Profesjonalne systemy nawadniania, modernizacje i serwis — dopasowane do każdego ogrodu.
      </p>
    </div>
    <div class="ofertaArchive__heroDeco" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#f8fafc"/>
      </svg>
    </div>
  </div>

  {{-- Grid --}}
  <div class="ofertaArchive__body">
    <div class="container-content">

      @if (have_posts())
        <div class="ofertaArchive__grid">
          @while(have_posts()) @php(the_post())
            @include('partials.card-oferta')
          @endwhile
        </div>

        {!! get_the_posts_pagination([
          'mid_size'  => 2,
          'prev_text' => '← ' . __('Poprzednie', 'verdion'),
          'next_text' => __('Następne', 'verdion') . ' →',
        ]) !!}

      @else
        <p class="archiveEmpty">{{ __('Brak ofert do wyświetlenia.', 'verdion') }}</p>
      @endif

    </div>
  </div>

@endsection
