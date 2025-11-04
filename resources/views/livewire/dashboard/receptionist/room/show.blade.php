<div>
    <div class="mb-6">
        <a href="{{ route('dashboard.receptionist.rooms.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Quay lại sơ đồ phòng
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Room Information --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Room Card --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative h-64">
                    <img src="{{ asset('storage/' . $room->image) }}" 
                         alt="{{ $room->name }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-xl">
                        {{ $room->room_number }}
                    </div>
                </div>

                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $room->name }}</h1>
                    <p class="text-gray-600 mb-4">Tầng {{ $room->floor }} - Phòng {{ $room->room_number }}</p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600">Giá phòng/đêm</div>
                            <div class="text-2xl font-bold text-blue-600">${{ number_format($room->price, 0) }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600">Rating</div>
                            <div class="text-2xl font-bold text-yellow-600">{{ $room->rate }} ⭐</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600">Tổng số phòng</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $room->total_rooms }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600">Còn trống</div>
                            <div class="text-2xl font-bold text-green-600">{{ $room->available }}</div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Mô tả phòng</h3>
                        <p class="text-gray-600">{{ $room->description }}</p>
                    </div>
                </div>
            </div>

            {{-- Reservations --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Danh sách đặt phòng</h2>
                
                @forelse($room->reservations as $reservation)
                    <div class="border-b last:border-b-0 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-bold text-gray-800">{{ $reservation->code }}</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $reservation->status == 'check in' ? 'bg-red-100 text-red-700' : 
                                           ($reservation->status == 'confirmed' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </div>
                                
                                <div class="space-y-1 text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium">Khách hàng:</span> 
                                        {{ $reservation->user->name ?? 'N/A' }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Check-in:</span> 
                                        {{ \Carbon\Carbon::parse($reservation->check_in)->format('d/m/Y') }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Check-out:</span> 
                                        {{ \Carbon\Carbon::parse($reservation->check_out)->format('d/m/Y') }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Số phòng:</span> 
                                        {{ $reservation->total_rooms }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Tổng giá:</span> 
                                        <span class="text-blue-600 font-semibold">${{ number_format($reservation->total_price, 0) }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('dashboard.receptionist.reservations.index') }}" 
                               class="px-4 py-2 bg-gray-800 text-white text-sm rounded hover:bg-gray-700">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p>Chưa có đặt phòng nào</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Facilities --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Tiện nghi</h3>
                <div class="space-y-2">
                    @forelse($room->facilities as $facility)
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">{{ $facility->facility->name ?? 'N/A' }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Chưa có tiện nghi nào</p>
                    @endforelse
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-blue-50 rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Thống kê</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Lượt xem</span>
                        <span class="font-semibold text-gray-800">{{ $room->views }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Đánh giá</span>
                        <span class="font-semibold text-gray-800">{{ $room->reviews->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Đặt phòng</span>
                        <span class="font-semibold text-gray-800">{{ $room->reservations->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
