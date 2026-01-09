@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create Inquiry</h1>
            <p class="mt-2 text-gray-600">Add a new inquiry</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.inquiries.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                    <select id="client_id" name="client_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('client_id') border-red-500 @enderror">
                        <option value="">— Optional —</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>
                                {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                    <select id="service_id" name="service_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('service_id') border-red-500 @enderror">
                        <option value="">— Optional —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                    @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t pt-6 flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Create Inquiry
                    </button>
                    <a href="{{ route('admin.inquiries.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
