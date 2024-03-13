<!-- Main modal -->
<div id="modal-saveProduct" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Nuevo Producto
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal-saveProduct">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form method="POST" action="{{ route('sys.saveProduct') }}" onsubmit="return onSaveProduct(this);">@csrf
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">

                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-code" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Codígo:</label>
                        <input 
                            type="text" 
                            id="modal-saveProduct-code"
                            name="code" 
                            class="block outline-none w-full p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            required 
                        />
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-category_id" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Categoría:</label>
                        <select 
                            id="modal-saveProduct-category_id" 
                            name="category_id"
                            class="block outline-none w-full p-2 text-sm text-gray-900 border  rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
                        ></select>
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-product_type_id" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Tipo:</label>
                        <select 
                            id="modal-saveProduct-product_type_id" 
                            name="product_type_id"
                            class="block outline-none w-full p-2 text-sm text-gray-900 border  rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
                        ></select>
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-product_measure_id" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Medida:</label>
                        <select 
                            id="modal-saveProduct-product_measure_id" 
                            name="product_measure_id"
                            class="block outline-none w-full p-2 text-sm text-gray-900 border  rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
                        ></select>
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-material_id" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Material:</label>
                        <select 
                            id="modal-saveProduct-material_id" 
                            name="material_id"
                            class="block outline-none w-full p-2 text-sm text-gray-900 border  rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
                        ></select>
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-product_librage_id" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Libraje:</label>
                        <select 
                            id="modal-saveProduct-product_librage_id" 
                            name="product_librage_id"
                            class="block outline-none w-full p-2 text-sm text-gray-900 border  rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
                        ></select>
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-brand_id" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Marca:</label>
                        <select 
                            id="modal-saveProduct-brand_id" 
                            name="brand_id"
                            class="block outline-none w-full p-2 text-sm text-gray-900 border rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
                        ></select>
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-quantity" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Cantidad:</label>
                        <div class="relative flex items-center w-full">
                            <button type="button" id="decrement-button" data-input-counter-decrement="modal-saveProduct-quantity" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border  rounded-s-lg p-2 h-9 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                </svg>
                            </button>
                            <input type="text" name="quantity" id="modal-saveProduct-quantity" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 outline-none border h-9 text-center text-gray-900 text-sm  focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" placeholder="0" required />
                            <button type="button" id="increment-button" data-input-counter-increment="modal-saveProduct-quantity" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border  rounded-e-lg p-2 h-9 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-weight" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Peso (KG):</label>
                        <input 
                            type="number" 
                            id="modal-saveProduct-weight" 
                            name="weight"
                            class="bg-gray-50 border outline-none text-gray-900 text-sm rounded-lg  focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            placeholder="0.00" 
                            min="0" 
                            step="0.1"
                            required 
                        />
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-unit_price" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Precio compra:</label>
                        <input 
                            type="number" 
                            id="modal-saveProduct-unit_price" 
                            name="unit_price"
                            class="bg-gray-50 border outline-none text-gray-900 text-sm rounded-lg  focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            placeholder="0.00" 
                            min="0" 
                            step="0.1"
                            required 
                        />
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-sale_price" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Precio venta:</label>
                        <input 
                            type="number" 
                            id="modal-saveProduct-sale_price" 
                            name="sale_price"
                            class="bg-gray-50 border outline-none text-gray-900 text-sm rounded-lg  focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            placeholder="0.00" 
                            min="0" 
                            step="0.1"
                            required 
                        />
                    </div>

                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-ubication" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Ubicación:</label>
                        <input 
                            type="text" 
                            id="modal-saveProduct-ubication"
                            name="ubication" 
                            class="block outline-none w-full p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            required 
                        />
                    </div>
                
                    <div class="mb-5">
                        <label 
                            for="modal-saveProduct-checking_date" 
                            class="text-right text-gray-800 dark:text-gray-50 mr-1 p-1 w-44"
                        >Fecha entrada:</label>
                        <input 
                            type="date" 
                            id="modal-saveProduct-checking_date" 
                            name="checking_date"
                            class="block w-full p-2 text-sm text-gray-900 border outline-none rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
                            required 
                        />
                    </div>
                
                    <input type="hidden" id="modal-saveProduct-id" name="id">
                </div>
                

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button 
                        type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar
                    </button>
                    <button data-modal-hide="modal-saveProduct" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>