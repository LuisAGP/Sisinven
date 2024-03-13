<div>

    <div class="mb-5 relative">
        <button 
            onclick="openOptions(this)"
            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 dark:border-gray-700 dark:text-white rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" type="button"
            >
            <span arial-input="text"> -- </span> 
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <input 
            type="hidden" 
            id={{$id}}
            name="{{$name}}"
            value="{{isset($defaultValue) ? $defaultValue : ''}}" 
            data-text=""
            arial-input="value"/>
        <div 
            arial-panel="options"
            class="absolute hidden top-12 z-10 left-0 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 min-w-52 overflow-hidden"
            >
            <div class="p-2">
                <input 
                    type="search" 
                    data-url="{{$url}}"
                    data-id="{{$id}}"
                    arial-type="search"
                    placeholder="Buscar..." 
                    class="block w-full p-2 outline-none text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-200 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{isset($defaultText) ? $defaultText : ''}}"
                    onfocusout="closeOptions(event)"
                    onkeyup="searcOptions(this)"
                />
            </div>
            <ul class="text-sm text-gray-700 dark:text-gray-200 max-h-48 overflow-y-scroll" id="options-{{$id}}">
                <li>
                    <button 
                        data-dselect_text=""
                        data-dselect_value=""
                        type="button" 
                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    >No hay información</button>
                </li>
            </ul>
        </div>
    </div>

</div>