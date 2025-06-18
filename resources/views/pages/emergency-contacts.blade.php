@extends('layout.app')
@section('title', 'Kontak Darurat')

@push('page-styles')
    @vite('resources/css/contact-page.css')
@endpush

@section('content')

    @php
        $breadcrumbs = [['name' => 'Beranda', 'url' => route('home')], ['name' => 'Kontak Darurat']];
    @endphp
    <x-hero title="Kontak Darurat"
        subtitle="Jika Anda atau seseorang yang Anda kenal membutuhkan bantuan segera, jangan ragu untuk
                menghubungi kontak di bawah ini."
        :breadcrumbs="$breadcrumbs" />

    <div class="container my-5">

        @if ($contacts->isEmpty())
            <p class="text-center">Informasi kontak darurat belum tersedia.</p>
        @else
            @foreach ($contacts as $type => $contactList)
                <div class="mb-5">
                    <h2 class="mb-4 contact-type-header">{{ $type }}</h2>
                    <div class="row g-4">
                        @foreach ($contactList as $contact)
                            <div class="col-md-6 col-lg-4">
                                <div class="contact-card">
                                    <div class="contact-icon"><i class="bi {{ $contact->icon }}"></i></div>
                                    <h5 class="contact-name">{{ $contact->name }}</h5>
                                    <p class="contact-description">{{ $contact->description }}</p>
                                    <div class="contact-info">{{ $contact->contact_info }}</div>

                                    @php
                                        $info = $contact->contact_info;

                                        $numberOnly = preg_replace('/[^0-9]/', '', $info);
                                        if (
                                            str_contains(strtolower($info), 'wa.me') ||
                                            (str_starts_with($numberOnly, '08') && strlen($numberOnly) >= 10)
                                        ) {
                                            $numberToFormat = $numberOnly;
                                            if (str_starts_with($numberToFormat, '0')) {
                                                $numberToFormat = '62' . substr($numberToFormat, 1);
                                            }
                                            $link = 'https://wa.me/' . $numberToFormat;
                                            $text = 'Hubungi via WhatsApp';
                                            $icon = 'bi-whatsapp';
                                        } else {
                                            $telNumber = preg_replace('/[^0-9+]/', '', $info);
                                            $link = 'tel:' . $telNumber;
                                            $text = 'Hubungi Sekarang';
                                            $icon = 'bi-telephone-outbound-fill';
                                        }
                                    @endphp

                                    <a href="{{ $link }}" class="btn btn-danger mt-3" target="_blank"
                                        rel="noopener noreferrer">
                                        <i class="bi {{ $icon }} me-2"></i> {{ $text }}
                                    </a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
