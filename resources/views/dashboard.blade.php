<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- build dashboard containers --}}
            <div class="flex justify-center bg-gray-100 py-10 p-14">
                <!-- First Stats Container-->
                <div class="container mx-auto pr-4">
                    <div
                        class="w-72 bg-white max-w-xs mx-auto rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100 cursor-pointer">
                        <div class="h-20 bg-blue-500 flex items-center justify-between">
                            <p class="mr-0 text-white text-lg pl-5">UPCOMING APPOINTMENTS</p>
                        </div>
                        <div class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600">
                            <p>TOTAL</p>
                        </div>
                        {{-- the count of upcoming appointment has been returned --}}
                        {{-- as you can see, the upcoming appointments are returned correctly --}}
                        <p class="py-4 text-3xl ml-5">{{ count($appointments) }}</p>
                    </div>
                </div>

                <!-- Second Stats Container-->
                <div class="container mx-auto pr-4">
                    <div
                        class="w-72 bg-white max-w-xs mx-auto rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100 cursor-pointer">
                        <div class="h-20 bg-blue-500 flex items-center justify-between">
                            <p class="mr-0 text-white text-lg pl-5">PATIENTS</p>
                        </div>
                        <div class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600">
                            <p>TOTAL</p>
                        </div>
                        <p class="py-4 text-3xl ml-5">{{ $doctor->doctor['patients'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Third Stats Container-->
                <div class="container mx-auto pr-4">
                    <div
                        class="w-72 bg-white max-w-xs mx-auto rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100 cursor-pointer">
                        <div class="h-20 bg-blue-500 flex items-center justify-between">
                            <p class="mr-0 text-white text-lg pl-5">RATINGS</p>
                        </div>
                        <div class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600">
                            <p>TOTAL</p>
                        </div>
                        <p class="py-4 text-3xl ml-5">
                            {{-- return avarage rating --}}
                            @if(isset($reviews))
                                @php
                                    // get total review count
                                        $count = count($reviews);
                                        $rating = 0;
                                        $total = 0;
                                        if($count != 0){
                                            foreach ($reviews as $review) {
                                                //get total rating
                                                $total += $review['ratings'];
                                            }
                                            $rating = $total / $count; //get average rating
                                        }else{
                                            $rating = 0;
                                        }
                                @endphp
                            @endif
                            {{-- return rating --}}
                            {{ $rating }}
                        </p>
                    </div>
                </div>

                <!-- Forth Stats Container-->
                <div class="container mx-auto pr-4">
                    <div
                        class="w-72 bg-white max-w-xs mx-auto rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100 cursor-pointer">
                        <div class="h-20 bg-blue-500 flex items-center justify-between">
                            <p class="mr-0 text-white text-lg pl-5">REVIEWS</p>
                        </div>
                        <div class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600">
                            <p>TOTAL</p>
                        </div>
                        {{-- this return how many reviews is given to doctor --}}
                        <p class="py-4 text-3xl ml-5">{{ count($reviews) }}</p>
                    </div>
                </div>
            </div>

            {{-- now retrieve reviews here --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="row">
                    <div class="col-md-7 mt-4">
                        <div class="card">
                            <div class="card-header my-3 pb-0 px-3">
                                <h6 class="mb-0">Latest Reviews</h6>
                            </div>
                            <div class="card-body pt-4 p-3">
                                {{-- check reviews is not empty --}}
                                @if(isset($reviews) && !$reviews->isEmpty())
                                    <ul class="list-group">
                                        @foreach ($reviews as $review)
                                            @if(isset($review->reviews) && $review->reviews != '')
                                                <article class="mb-6">
                                                    <div class="flex items-center mb-4 space-x-4">
                                                        <img class="w-10 h-10 rounded-full"
                                                             src="{{ $review->user->profile_photo_url }}" alt="">
                                                        <div class="space-y-1 font-medium">
                                                            <p>{{  $review->user->name }}
                                                                <time datetime="2014-08-16 19:00"
                                                                      class="block text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at ?? '-' }}</time>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center mb-1">
                                                        @for($i = 0; $i < $review->ratings; $i++)
                                                            <svg aria-hidden="true" class="w-5 h-5 text-yellow-400"
                                                                 fill="currentColor" viewBox="0 0 20 20"
                                                                 xmlns="http://www.w3.org/2000/svg"><title>First
                                                                    star</title>
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p class="mb-3 text-gray-500 dark:text-gray-400">{{ $review->reviews ?? '-' }}</p>
                                                    <a href="#"
                                                       class="block mb-5 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Read
                                                        more</a>
                                                    <aside>
                                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">19
                                                            people found this helpful</p>
                                                        <div
                                                            class="flex items-center mt-3 space-x-3 divide-x divide-gray-200 dark:divide-gray-600">
                                                            <a href="#"
                                                               class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-xs px-2 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Helpful</a>
                                                            <a href="#"
                                                               class="pl-4 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Report
                                                                abuse</a>
                                                        </div>
                                                    </aside>
                                                </article>
                                            @endif

                                        @endforeach
                                    </ul>
                                @else
                                    <div class="border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                                        <h6 class="mb-3 text-sm">No Reviews Yet!</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
