@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Преглед на запитване</h1>
                <p class="mt-2 text-gray-600">Прегледайте детайлите и при нужда изтрийте запитването.</p>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">← Назад към списъка</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
            <div>
                <h2 class="text-sm font-semibold text-gray-500 uppercase">Клиент</h2>
                <p class="mt-2 text-gray-900">{{ optional($inquiry->client)->first_name }} {{ optional($inquiry->client)->last_name }}</p>
                <p class="text-gray-700">{{ optional($inquiry->client)->email }}</p>
                <p class="text-gray-700">{{ optional($inquiry->client)->phone }}</p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500 uppercase">Категория</h2>
                <p class="mt-2 text-gray-900">{{ optional($inquiry->category)->getTranslation('name', 'bg') ?? '—' }}</p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500 uppercase">Съобщение</h2>
                <p class="mt-2 text-gray-900 whitespace-pre-line">{{ $inquiry->message }}</p>
            </div>

            <div class="flex justify-between text-sm text-gray-500">
                <span>Създадено: {{ $inquiry->created_at?->format('Y-m-d H:i') }}</span>
                <!-- <span>Обновено: {{ $inquiry->updated_at?->format('Y-m-d H:i') }}</span> -->
            </div>
        </div>

        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="mt-6"
            onsubmit="return confirm('Сигурни ли сте, че искате да изтриете това запитване?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium cursor-pointer">
                Изтрий запитване
            </button>
        </form>
    </div>
</div>
@endsection
