@extends('layouts.app')

@section('content')
    <div class="flex gap-8 md:gap-12 flex-col">
        <h2 class="text-balance text-2xl md:text-5xl text-blue-100 font-bold mt-8">Recentes</h2>

        <div class="gap-8 md:gap-8">
            <ul class="rounded-3xl text-balance text-base md:text-2xl text-neutral-100 default-theme px-12 py-10 h-157 md:h-171 w-60">
                @foreach ($repos as $repo)
                    <li>
                        <a href="{{ $repo['html_url'] }}" target="_blank"
                           class="block w-60 truncate text-blue-100 transition duration-300 hover:brightness-140">
                            {{ \Illuminate\Support\Str::limit($repo['name'], 10) }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <a class="underline decoration-2 underline-offset-2 md:text-2xl
            text-neutral-100 flex justify-end gap-8 md:gap-8 mt-8 items-end"  target="_blank"  href="{{ asset('storage/pdf/curriculojpm.pdf') }}">
                Currículo
            </a>
        </div>
    </div>
@endsection
