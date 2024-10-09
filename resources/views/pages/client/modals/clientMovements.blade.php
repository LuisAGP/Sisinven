<!-- Main modal -->
<div id="modal-clientMovements" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Movimientos: <small class="text-gray-600 dark:text-gray-300" id="modal-clientMovements-client"></small>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal-clientMovements">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
                
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">

                <div class="flex justify-center items-center gap-3">
                    <span class="text-gray-600 dark:text-gray-300">De:</span>
                    
                    <input 
                        type="date" 
                        id="modal-clientMovements-init_date"
                        class="inline-block outline-none p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                        required
                    />

                    <span class="text-gray-600 dark:text-gray-300">a:</span>

                    <input 
                        type="date" 
                        id="modal-clientMovements-end_date"
                        class="inline-block outline-none p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                        required
                    />

                    <button 
                        type="button"
                        onclick="loadDatatableClientMovements()"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Buscar 
                    </button>
                </div>

                <x-datatable :rows="['# Pedido', 'Importe', 'Tipo', 'Fecha']" :id="'datatableClientMovements'"/>
                <input type="hidden" id="modal-clientMovements-id">
            </div>

            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="modal-clientMovements" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>