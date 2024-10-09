<!-- Main modal -->
<div id="modal-payBalance" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Abonar a Deuda
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal-payBalance">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form method="POST" action="{{ route('sys.payBalance') }}" onsubmit="return onPayBalance(this);">@csrf
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">

                    <div class="mb-5">
                        <label 
                            for="modal-payBalance-pay_date" 
                            class="block text-gray-800 dark:text-gray-50 mr-1 py-1 mb-2"
                        >Fecha de pago:</label>
                        <input 
                            type="date" 
                            id="modal-payBalance-pay_date"
                            name="pay_date" 
                            class="block outline-none w-full p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            placeholder="0.00" 
                            min="0" 
                            step="0.1"
                            required
                        />
                    </div>

                    <div class="mb-5">
                        <label 
                            for="modal-payBalance-balance" 
                            class="block text-gray-800 dark:text-gray-50 mr-1 py-1 mb-2"
                        >Importe ($):</label>
                        <input 
                            type="number" 
                            id="modal-payBalance-balance"
                            name="balance" 
                            class="block outline-none w-full p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            placeholder="0.00" 
                            min="0" 
                            step="0.1"
                            required
                        />
                    </div>
                                
                    <input type="hidden" id="modal-payBalance-id" name="id">
                </div>
                

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button 
                        type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Abonar
                    </button>
                    <button data-modal-hide="modal-payBalance" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>