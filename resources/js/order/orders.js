import 'flowbite';
import { Modal } from 'flowbite';

document.addEventListener("DOMContentLoaded", function() {
    loadDatatableOrders();
});

document.getElementById('datatableOrders-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableOrders(search);
});

document.getElementById('datatableOrderDetails-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableOrderDetails(search);
});

window.modalCancelOrder = new Modal(document.getElementById('modal-cancelOrder'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalOrderDetails = new Modal(document.getElementById('modal-orderDetails'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableOrders = (complemento="") => {

    let fullUrl = complemento ? `${urlBase}/orders/${complemento}` : `${urlBase}/orders`;
    
    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            const tbody = document.getElementById('datatableOrders');

            tbody.innerHTML = "";

            for(let i of data.data){

                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${listButton('Ver detalles', 'openOrderDetailsModal('+i.id+')')}
                        ${cancelButton('Cancelar', 'openCancelOrderModal('+i.id+')')}
                    </td>
                    <td class="px-6 py-4">
                        ${i.id}
                    </td>
                    <td class="px-6 py-4">
                        ${formatDate(i.order_date)}
                    </td>
                    <td class="px-6 py-4">
                        ${i.client}
                    </td>
                    <td class="px-6 py-4">
                        ${moneyFormat.format(i.total)}
                    </td>
                </tr>`;
            }

            updatePagination('datatableOrders' ,data, 'loadDatatableOrders');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}


window.loadDatatableOrderDetails = (complemento="") => {

    const idOrder = document.getElementById('modal-orderDetails-id').value;
    const fullUrl = complemento 
        ? `${urlBase}/order_details/${idOrder}/${complemento}` 
        : `${urlBase}/order_details/${idOrder}`;

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            const tbody = document.getElementById('datatableOrderDetails');

            tbody.innerHTML = "";

            for(let i of data.data){

                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${i.description}
                    </td>
                    <td class="px-6 py-4">
                        ${i.quantity}
                    </td>
                    <td class="px-6 py-4">
                        ${moneyFormat.format(i.unit_price)}
                    </td>
                    <td class="px-6 py-4">
                        ${moneyFormat.format(i.total)}
                    </td>
                </tr>`;
            }

            updatePagination('datatableOrderDetails' ,data, 'loadDatatableOrderDetails');
        }
    });

}


window.openCancelOrderModal = (idOrder) => {

    document.getElementById('modal-cancelOrder-number').innerHTML = idOrder;
    document.getElementById('modal-cancelOrder-id').value = idOrder;
    modalCancelOrder.toggle();

}

window.openOrderDetailsModal = (idOrder) => {

    document.getElementById('modal-orderDetails-id').value = idOrder;
    loadDatatableOrderDetails();
    modalOrderDetails.toggle();

}


window.onCancelOrder = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableOrders();
            modalCancelOrder.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}
