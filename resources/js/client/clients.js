import 'flowbite';
import { Modal } from 'flowbite';

document.addEventListener("DOMContentLoaded", function() {
    loadDatatableClients();
});

document.getElementById('datatableClients-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableClients(search);
});

document.getElementById('datatableClientMovements-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableClientMovements(search);
});

window.modalSaveClient = new Modal(document.getElementById('modal-saveClient'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteClient = new Modal(document.getElementById('modal-deleteClient'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalPayBalance = new Modal(document.getElementById('modal-payBalance'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalClientMovements = new Modal(document.getElementById('modal-clientMovements'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableClients = (complemento="") => {

    const fullUrl = complemento ? urlBase + "/clients/" + complemento : urlBase + "/clients";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableClients');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4"
                        data-id="${i.id}"
                        data-client="${i.alias}"
                    >
                        ${editButton("Editar", "openSaveClientModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteClientModal("+i.id+")")}
                        ${moneyButton('Abonar', 'openPayBalanceModal('+i.id+')')}
                        ${listButton('Movimientos', 'openClientMovementsModal(this)')}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.name}
                    </td>   
                    <td class="px-6 py-4">
                        ${i.lastname}
                    </td>
                    <td class="px-6 py-4">
                        ${i.company}
                    </td>
                    <td class="px-6 py-4">
                        ${i.phone}
                    </td>
                    <td class="px-6 py-4">
                        ${i.rfc}
                    </td>
                    <td class="px-6 py-4">
                        ${i.regime}
                    </td>
                    <td class="px-6 py-4">
                        ${moneyFormat.format(i.balance)}
                    </td>
                </tr>`;
            }

            updatePagination('datatableClients' ,data, 'loadDatatableClients');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}


window.loadDatatableClientMovements = (complemento="") => {

    const initDate = document.getElementById("modal-clientMovements-init_date").value;
    const endDate = document.getElementById("modal-clientMovements-end_date").value;
    const idClient = document.getElementById('modal-clientMovements-id').value;

    const fullUrl = complemento
        ? `${urlBase}/client_movements/${idClient}/${complemento}&init_date=${initDate}&end_date=${endDate}`
        : `${urlBase}/client_movements/${idClient}?init_date=${initDate}&end_date=${endDate}`;

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableClientMovements');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${i.order_id}
                    </td>   
                    <td class="px-6 py-4">
                        ${moneyFormat.format(i.amount)}
                    </td>
                    <td class="px-6 py-4">
                        ${i.movement_type}
                    </td>
                    <td class="px-6 py-4">
                        ${formatDate(i.movement_date)}
                    </td>
                </tr>`;
            }

            updatePagination('datatableClientMovements' ,data, 'loadDatatableClientMovements');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}


window.openSaveClientModal = (idClient=null) => {

    let name = document.getElementById('modal-saveClient-name');
    let lastname = document.getElementById('modal-saveClient-lastname');
    let company = document.getElementById('modal-saveClient-company');
    let phone = document.getElementById('modal-saveClient-phone');
    let rfc = document.getElementById('modal-saveClient-rfc')
    let regime = document.getElementById('modal-saveClient-regime');
    let id = document.getElementById('modal-saveClient-id');

    name.value = "";
    lastname.value = "";
    company.value = "";
    phone.value = "";
    rfc.value = "";
    regime.value = "";
    id.value = "";

    if(idClient){
        ajax({
            url: urlBase + "/client/" + idClient,
            method: 'GET',
            complete: (data) => {
                name.value = data.name;
                lastname.value = data.lastname;
                company.value = data.company;
                phone.value = data.phone;
                rfc.value = data.rfc;
                regime.value = data.regime;
                id.value = data.id;

                modalSaveClient.toggle();
            }
        });
    }else{
        modalSaveClient.toggle();
    }

}

window.openDeleteClientModal = (idClient) => {

    let fullname = document.getElementById('modal-deleteClient-fullname');
    let id = document.getElementById('modal-deleteClient-id');

    fullname.innerHTML = "";
    id.value = "";

    if(idClient){
        ajax({
            url: urlBase + "/client/" + idClient,
            method: 'GET',
            complete: (data) => {
                fullname.innerHTML = data.name + " " + data.lastname;
                id.value = data.id;

                modalDeleteClient.toggle();
            }
        });
    }

}

window.openPayBalanceModal = (idClient) => {

    document.getElementById('modal-payBalance-id').value = idClient;
    document.getElementById('modal-payBalance-pay_date').value = "";
    document.getElementById('modal-payBalance-balance').value = "";

    modalPayBalance.toggle();

}

window.openClientMovementsModal = (btn) => {

    document.getElementById('modal-clientMovements-id').value = btn.parentNode.dataset.id;
    document.getElementById('modal-clientMovements-client').innerHTML = btn.parentNode.dataset.client;

    loadDatatableClientMovements();
    modalClientMovements.toggle();

}

window.onSaveClient = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableClients();
            modalSaveClient.toggle();
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;
}


window.onDeleteClient = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableClients();
            modalDeleteClient.toggle()
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}

window.onPayBalance = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableClients();
            modalPayBalance.toggle()
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}