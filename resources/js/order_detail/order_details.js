import 'flowbite';
import { Modal } from 'flowbite';

let productos = [];
let totalGlobal = 0;

document.getElementById('datatableProducts-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableProducts(search);
});

window.modalAddProduct = new Modal(document.getElementById('modal-addProduct'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalProceedOrder = new Modal(document.getElementById('modal-proceedOrder'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.openAddProductModal = () => {

    loadDatatableProducts();
    modalAddProduct.toggle();
    
}

window.openProceedOrderModal = () => {

    let orderDate = document.getElementById('orderDetail-date');
    let client = document.getElementById('orderDetail-clientId');

    if(!orderDate.value){
        errorAlert("Introduzca la <b>Fecha del pedido</b>.");
        return false;
    }else if(!client.value){
        errorAlert("No se ha seleccionado <b>cliente</b>.");
        return false;
    }else if(productos.length === 0){
        errorAlert("Aún no tiene <b>Productos</b> seleccionados.");
        return false;
    }

    totalGlobal = 0;

    productos.map(i => { totalGlobal += i.quantity*i.price; })

    document.getElementById('modal-proceedOrder-orderDate').innerHTML = orderDate.value;
    document.getElementById('modal-proceedOrder-clientName').innerHTML = client.dataset.text;
    document.getElementById('modal-proceedOrder-total').innerHTML = moneyFormat.format(totalGlobal);

    modalProceedOrder.toggle();

}

window.loadDatatableOrderDetails = () => {

    const tbody = document.getElementById('datatableOrderDetails');
    tbody.innerHTML = "";

    totalGlobal = 0;

    for(let i of productos){

        let select = `<select
            onchange="updateOrderDetail(${i.id}, this, ${i.price});" 
            class="block text-center outline-none p-2 text-sm text-gray-900 border rounded-lg bg-gray-50  focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500"
        >`;

        for(let c = 1; c <= i.limit; c++){
            if(c == i.quantity){
                select += `<option value="${c}" selected>${c}</option>`;
            }else{
                select += `<option value="${c}">${c}</option>`;
            }
        }

        select += "</select>";

        let input = `<input 
            type="text" 
            class="bg-gray-50 w-20 text-center border outline-none text-gray-900 text-sm rounded-lg  focus:border-blue-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark: dark:focus:border-blue-500" 
            value="${parseFloat(i.price).toFixed(2)}"
            onchange="updateOrderDetail(${i.id}, ${i.quantity}, this);" 
            onkeyup="changeInput(event);"
        />`;

        tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">
                ${deleteButton("Eliminar", 'deleteProductOrderDetail('+i.id+')')}
            </td> 
            <td class="px-6 py-4">
                ${i.description}
            </td>
            <td class="px-6 py-4">
                ${select}
            </td>
            <td class="px-6 py-4">
                ${input}
            </td>
            <td class="px-6 py-4">
                ${moneyFormat.format(i.price*i.quantity)}
            </td>
        </tr>`;

        totalGlobal += i.price*i.quantity;

    }

    document.getElementById('orderDetail-totalGlobal').value = moneyFormat.format(totalGlobal);

}

window.loadDatatableProducts = (complemento="") => {

    const ids = productos.map(i => i.id).join('|');
    let fullUrl = complemento ? `${urlBase}/products/${complemento}&exclude=${ids}` : `${urlBase}/products?exclude=${ids}`;
    
    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            const tbody = document.getElementById('datatableProducts');

            tbody.innerHTML = "";

            for(let i of data.data){

                const product = [
                    i.category,
                    i.brand,
                    i.type,
                    i.material,
                    i.measure.replace('"', '”'),
                    i.librage,
                    i.weight.replace('.00', '') + " KG"
                ].join(' ');

                const callback = `addProduct(${i.id}, '${product}', ${i.sale_price}, ${i.quantity}, '${complemento}')`;

                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${i.quantity > 0 ? addButton("Agregar", callback) : ''}
                    </td> 
                    <td class="px-6 py-4">
                        ${product}
                    </td>
                    <td class="px-6 py-4">
                        ${moneyFormat.format(i.sale_price)}
                    </td>
                    <td class="px-6 py-4">
                        ${i.quantity}
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

window.deleteProductOrderDetail = (id) => { 
    productos = productos.filter(i => i.id !== id);
    loadDatatableOrderDetails();
}

window.addProduct = (id, descript, price, limit, complemento) => {

    productos.push({
        id: id,
        description: descript,
        price: price,
        quantity: 1,
        limit: limit
    });

    loadDatatableOrderDetails();
    loadDatatableProducts(complemento);

}

window.changeInput = (e) => {
    if (e.keyCode === 13) { e.target.change();}
}

window.updateOrderDetail = (id, quantity, price) => {

    if(quantity instanceof Element){
        productos = productos.map(i => {
            if(i.id == id){ i.quantity = quantity.value;}
            return i;
        });
    }else if(price instanceof Element){
        productos = productos.map(i => {
            if(i.id == id){
                if(parseFloat(price.value)){
                    i.price = parseFloat(price.value);
                }else{
                    price.value = i.price;
                }
            }
            return i;
        });
    }else{
        productos = productos.map(i => {
            if(i.id == id){
                
                try {
                    i.quantity = quantity
                    i.price = parseFloat(price);
                } catch (error) {
                    return i;
                }

            }
            return i;
        });
    }

    loadDatatableOrderDetails();

}


window.onCreateOrder = (form) => {

    try {

        const products = productos.map(i => {
            return {
                id: i.id,
                quantity: i.quantity,
                price: i.price
            }
        });

        let data = new FormData();

        data.append('order_date', document.getElementById('orderDetail-date').value);
        data.append('client_id', document.getElementById('orderDetail-clientId').value);
        data.append('products', JSON.stringify(products));

        ajax({
            url: form.action,
            body: data,
            success: (data) => {
                window.location = urlBase;
                modalProceedOrder.toggle();
            },
            error: (err) => {
                errorAlert(err.message);
            }
        });
        
    } catch (error) {
        console.error(error);
    }

    return false;

}
