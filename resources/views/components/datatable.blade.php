<div>

    @if (!$hideSearchInput)
    <div class="pb-4 bg-transparent">
        <label for="table-search" class="sr-only">Buscar</label>
        <div class="relative mt-1 flex">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text"
                id="{{$id}}-searcher"
                class="block py-2 ps-10 outline-none text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Buscar elemento">
        </div>
    </div>
    @endif

    <div class="relative overflow-x-auto sm:rounded-lg shadow-md mb-5 overflow-y-scroll">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @foreach ($rows as $row)
                    <th scope="col" class="px-6 py-3 min-w-32">
                        {{$row}}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody id="{{$id}}"></tbody>
        </table>    
    </div>

    {{-- Pagination --}}
    <nav>
        <ul class="flex items-center -space-x-px h-8 text-sm" id="{{$id}}-pagination"></ul>
    </nav>

</div>