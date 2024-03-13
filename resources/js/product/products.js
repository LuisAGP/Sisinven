import 'flowbite';
import { Modal } from 'flowbite';

document.addEventListener("DOMContentLoaded", function() {
    loadDatatableProducts();
    loadProductSelects();
});

document.getElementById('datatableProducts-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableProducts(search);
});

window.modalSaveProduct = new Modal(document.getElementById('modal-saveProduct'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteProduct = new Modal(document.getElementById('modal-deleteProduct'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableProducts = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/products/" + complemento : urlBase + "/products";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableProducts');

            tbody.innerHTML = "";

            for(let i of data.data){

                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openSaveProductModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteProductModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.category}
                    </td>   
                    <td class="px-6 py-4">
                        ${i.type}
                    </td>
                    <td class="px-6 py-4">
                        ${i.measure}
                    </td>
                    <td class="px-6 py-4">
                        ${i.material}
                    </td>
                    <td class="px-6 py-4">
                        ${i.librage}
                    </td>
                    <td class="px-6 py-4">
                        ${i.ubication}
                    </td>
                    <td class="px-6 py-4">
                        ${i.quantity}
                    </td>
                    <td class="px-6 py-4">
                        ${i.brand}
                    </td>
                </tr>`;
            }

            updatePagination('datatableProducts' ,data, 'loadDatatableProducts');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}


window.loadProductSelects = () => {

    try {
        
        ajax({
            url: urlBase + "/product_info_selects/",
            method: 'GET',
            success: (data) => {
                
                let category = document.getElementById('modal-saveProduct-category_id');
                let type = document.getElementById('modal-saveProduct-product_type_id');
                let measure = document.getElementById('modal-saveProduct-product_measure_id');
                let material = document.getElementById('modal-saveProduct-material_id');
                let librage = document.getElementById('modal-saveProduct-product_librage_id');
                let brand = document.getElementById('modal-saveProduct-brand_id');

                category.innerHTML = "";
                type.innerHTML = "";
                measure.innerHTML = "";
                material.innerHTML = "";
                librage.innerHTML = "";
                brand.innerHTML = "";

                data.categories.forEach(i => {
                    category.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                });

                data.types.forEach(i => {
                    type.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                });

                data.measures.forEach(i => {
                    measure.innerHTML += `<option value="${i.id}">${i.value}</option>`;
                });

                data.materials.forEach(i => {
                    material.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                });

                data.librages.forEach(i => {
                    librage.innerHTML += `<option value="${i.id}">${i.value}</option>`;
                });

                data.brands.forEach(i => {
                    brand.innerHTML += `<option value="${i.id}">${i.name}</option>`; 
                });

            }
        });

    } catch (error) {
        console.log(error);
    }

}


window.openSaveProductModal = (idProduct=null) => {

    let code = document.getElementById('modal-saveProduct-code');
    let category = document.getElementById('modal-saveProduct-category_id');
    let type = document.getElementById('modal-saveProduct-product_type_id');
    let measure = document.getElementById('modal-saveProduct-product_measure_id');
    let material = document.getElementById('modal-saveProduct-material_id');
    let librage = document.getElementById('modal-saveProduct-product_librage_id');
    let brand = document.getElementById('modal-saveProduct-brand_id');
    let quantity = document.getElementById('modal-saveProduct-quantity');
    let weight = document.getElementById('modal-saveProduct-weight');
    let unit_price = document.getElementById('modal-saveProduct-unit_price');
    let sale_price = document.getElementById('modal-saveProduct-sale_price');
    let ubication = document.getElementById('modal-saveProduct-ubication');
    let checking_date = document.getElementById('modal-saveProduct-checking_date');
    let id = document.getElementById('modal-saveProduct-id');

    code.value = "";
    category.value = "";
    type.value = "";
    measure.value = "";
    material.value = "";
    librage.value = "";
    brand.value = "";
    quantity.value = "";
    weight.value = "";
    unit_price.value = "";
    sale_price.value = "";
    ubication.value = "";
    checking_date.value = "";
    id.value = "";

    if(idProduct){
        ajax({
            url: urlBase + "/product/" + idProduct,
            method: 'GET',
            complete: (data) => {
                
                code.value = data.code;
                category.value = data.category_id;
                type.value = data.product_type_id;
                measure.value = data.product_measure_id;
                material.value = data.material_id;
                librage.value = data.product_librage_id;
                brand.value = data.brand_id;
                quantity.value = data.quantity;
                weight.value = data.weight;
                unit_price.value = data.unit_price;
                sale_price.value = data.sale_price;
                ubication.value = data.ubication;
                checking_date.value = data.checking_date.split(' ')[0];
                id.value = data.id;

                modalSaveProduct.toggle();
            }
        });
    }else{
        modalSaveProduct.toggle();
    }

}


window.openDeleteProductModal = (idProduct) => {

    let example = document.getElementById('modal-deleteProduct-example');
    let id = document.getElementById('modal-deleteProduct-id');

    example.innerHTML = "";
    id.value = "";

    if(idProduct){
        ajax({
            url: urlBase + "/product/" + idProduct,
            method: 'GET',
            complete: (data) => {
                example.innerHTML = data.category + " " + data.weight;
                id.value = data.id;

                modalDeleteProduct.toggle();
            }
        });
    }

}

window.onSaveProduct = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableProducts();
            modalSaveProduct.toggle();
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;
}


window.onDeleteProduct = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableProducts();
            modalDeleteProduct.toggle()
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}