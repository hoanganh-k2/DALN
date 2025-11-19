<div class="p-6">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <i class='bx bx-check-circle text-xl'></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Sơ đồ phòng theo tầng</h1>
        
        {{-- Legend --}}
        <div class="flex items-center gap-4 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-white border-2 border-gray-300 rounded"></div>
                <span>Còn trống</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-red-50 border-2 border-red-400 rounded"></div>
                <span>Chờ xác nhận</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-green-500 rounded"></div>
                <span>Đã đặt</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-teal-600 rounded"></div>
                <span>Đang ở</span>
            </div>
        </div>
    </div>

    {{-- Floor Tabs - Horizontal Scrollable like KiotViet --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
            <button class="px-3 py-2 text-gray-400 hover:text-gray-600">
                <i class='bx bx-chevron-left text-2xl'></i>
            </button>
            
            @foreach($floors as $floor)
                <button 
                    wire:click="selectFloor({{ $floor }})"
                    class="px-6 py-2 font-semibold transition-all whitespace-nowrap rounded-lg
                        {{ $selectedFloor == $floor 
                            ? 'bg-gray-800 text-white shadow-md' 
                            : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' 
                        }}"
                >
                    Tầng {{ $floor }}
                </button>
            @endforeach
            
            <button class="px-3 py-2 text-gray-400 hover:text-gray-600">
                <i class='bx bx-chevron-right text-2xl'></i>
            </button>
        </div>
    </div>

    {{-- Room Grid - KiotViet Style - 4 phòng mỗi tầng --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 max-w-6xl mx-auto auto-rows-fr">
        @forelse($rooms as $room)
            @php
                $status = $this->getRoomStatus($room);
                
                // Determine background color based on reservation status
                $statusConfig = [
                    'available' => [
                        'bg' => 'bg-white',
                        'border' => 'border-gray-300',
                        'text' => 'text-gray-800',
                    ],
                    'waiting' => [
                        'bg' => 'bg-red-50',
                        'border' => 'border-red-400',
                        'text' => 'text-red-800',
                    ],
                    'reserved' => [
                        'bg' => 'bg-green-500',
                        'border' => 'border-green-600',
                        'text' => 'text-white',
                    ],
                    'occupied' => [
                        'bg' => 'bg-teal-600',
                        'border' => 'border-teal-700',
                        'text' => 'text-white',
                    ],
                ];
                $config = $statusConfig[$status] ?? $statusConfig['available'];
                
                // Cleaning status badge
                $cleaningConfig = [
                    'clean' => ['badge' => 'bg-gray-100 text-gray-700', 'label' => 'Sạch', 'icon' => 'bx-check-circle'],
                    'dirty' => ['badge' => 'bg-red-100 text-red-700', 'label' => 'Chưa dọn', 'icon' => 'bx-x-circle'],
                    'cleaning' => ['badge' => 'bg-yellow-100 text-yellow-700', 'label' => 'Đang dọn', 'icon' => 'bx-loader-circle'],
                ];
                $cleaningInfo = $cleaningConfig[$room->cleaning_status] ?? $cleaningConfig['clean'];
                
                // Get active reservation info
                $activeReservation = $room->reservations->whereIn('status', ['check in', 'confirmed'])->first();
            @endphp

            <div class="relative group h-full">
                <button 
                    wire:click="$emit('openRoomDetail', '{{ $room->code }}')"
                    class="{{ $config['bg'] }} {{ $config['border'] }} border-2 rounded-lg p-3 hover:shadow-lg transition-all cursor-pointer relative overflow-hidden w-full h-full min-h-[180px] flex flex-col"
                >
                    {{-- Cleaning Status Badge (Top Left) --}}
                    @if($status == 'available')
                        <div class="absolute top-1 left-1 {{ $cleaningInfo['badge'] }} text-[10px] px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                            <i class='bx {{ $cleaningInfo['icon'] }}'></i>
                            {{ $cleaningInfo['label'] }}
                        </div>
                    @endif

                {{-- Reservation Status Badge (Top Right) --}}
                @if(in_array($status, ['reserved', 'occupied']))
                    <div class="absolute top-1 right-1 bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-semibold text-white backdrop-blur-sm">
                        @if($status == 'occupied')
                            <i class='bx bx-user'></i> Đang ở
                        @else
                            <i class='bx bx-calendar-check'></i> Đã đặt
                        @endif
                    </div>
                @elseif($status == 'waiting')
                    <div class="absolute top-1 right-1 bg-red-200 text-[10px] px-2 py-0.5 rounded-full font-semibold text-red-800">
                        <i class='bx bx-time'></i> Chờ xác nhận
                    </div>
                @endif
                    
                    {{-- Room Number --}}
                    <div class="flex-shrink-0 mt-6">
                        <h3 class="text-xl font-bold {{ $config['text'] }}">{{ $room->room_number }}</h3>
                        <p class="text-xs {{ $config['text'] }} opacity-75">{{ $room->name }}</p>
                    </div>

                    {{-- Flexible spacer to push content to bottom --}}
                    <div class="flex-grow min-h-[20px]"></div>

                    {{-- Reservation Info for occupied rooms --}}
                    @if($activeReservation && in_array($status, ['reserved', 'occupied']))
                        <div class="text-left space-y-1 mt-2 pt-2 border-t border-white/30 min-h-[48px]">
                            <div class="flex items-center gap-1 text-xs {{ $config['text'] }}">
                                <i class='bx bx-time-five'></i>
                                <span>{{ \Carbon\Carbon::parse($activeReservation->check_in)->diffInDays(\Carbon\Carbon::parse($activeReservation->check_out)) }} ngày / {{ \Carbon\Carbon::parse($activeReservation->check_out)->diffInDays(\Carbon\Carbon::now()) }} ngày</span>
                            </div>
                        </div>
                    @else
                        {{-- Price for available rooms --}}
                        <div class="text-left mt-2 pt-2 border-t border-gray-200 min-h-[48px]">
                            <p class="text-sm font-semibold text-gray-800">${{ number_format($room->price, 0) }}</p>
                            <p class="text-xs text-gray-500">${{ number_format($room->price, 0) }}/đêm</p>
                        </div>
                    @endif

                    {{-- Hover Effect --}}
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"></div>
                </button>

                {{-- Quick Actions Menu (appears on hover) --}}
                @if($status == 'available')
                    <div class="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <div class="relative">
                            <button 
                                onclick="event.stopPropagation()" 
                                class="p-1 bg-gray-800 text-white rounded-bl-lg rounded-tr-lg hover:bg-gray-700"
                                x-data x-on:click="$refs.menu{{ $room->id }}.classList.toggle('hidden')"
                            >
                                <i class='bx bx-dots-vertical-rounded'></i>
                            </button>
                            <div 
                                x-ref="menu{{ $room->id }}"
                                class="hidden absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-20"
                                onclick="event.stopPropagation()"
                            >
                                @if($room->cleaning_status == 'dirty')
                                    <button 
                                        wire:click="markRoomCleaning('{{ $room->code }}')" 
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                                    >
                                        <i class='bx bx-loader-circle text-yellow-600'></i>
                                        Đang dọn
                                    </button>
                                    <button 
                                        wire:click="markRoomCleaned('{{ $room->code }}')" 
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                                    >
                                        <i class='bx bx-check-circle text-green-600'></i>
                                        Đánh dấu sạch
                                    </button>
                                @elseif($room->cleaning_status == 'cleaning')
                                    <button 
                                        wire:click="markRoomCleaned('{{ $room->code }}')" 
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                                    >
                                        <i class='bx bx-check-circle text-green-600'></i>
                                        Đánh dấu sạch
                                    </button>
                                @else
                                    <button 
                                        wire:click="markRoomDirty('{{ $room->code }}')" 
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                                    >
                                        <i class='bx bx-x-circle text-red-600'></i>
                                        Cần dọn
                                    </button>
                                @endif
                                <hr class="my-1">
                                <a 
                                    href="{{ route('dashboard.receptionist.rooms.show', $room->code) }}" 
                                    class="block px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                                >
                                    <i class='bx bx-detail'></i>
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Không có phòng</h3>
                <p class="mt-1 text-sm text-gray-500">Tầng này chưa có phòng nào.</p>
            </div>
        @endforelse
    </div>

    {{-- Summary Statistics - Compact --}}
    @if($rooms->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-800">{{ $rooms->count() }}</div>
                    <div class="text-sm text-gray-600 mt-1">Tổng số phòng</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">
                        {{ $rooms->count() - $rooms->filter(fn($r) => $this->getRoomStatus($r) == 'occupied')->count()}}
                    </div>
                    <div class="text-sm text-gray-600 mt-1">Còn trống</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $this->getReservationTotalByStatus($rooms) }}
                    </div>
                    <div class="text-sm text-gray-600 mt-1">Chờ check-in</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-teal-600">
                        {{ $rooms->filter(fn($r) => $this->getRoomStatus($r) === 'occupied')->count() }}
                    </div>
                    <div class="text-sm text-gray-600 mt-1">Đang ở</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Room Detail Panel (Optional Modal) --}}
    <div class="text-center py-4 text-sm text-gray-500">
        <p>Nhấn vào phòng để xem chi tiết và quản lý</p>
    </div>
</div>
