import 'flowbite';
import { Modal } from 'flowbite';

document.getElementById('datatableTypes-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value
    loadDatatableTypes(search);
});

window.modalNewType = new Modal(document.getElementById('modal-newType'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteType = new Modal(document.getElementById('modal-deleteType'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableTypes = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/types/" + complemento : urlBase + "/types";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableTypes');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openSaveTypeModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteTypeModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.name}
                    </td> 
                </tr>`;
            }

            updatePagination('datatableTypes' ,data, 'loadDatatableTypes');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

window.openSaveTypeModal = (idType) => {
    document.getElementById('modal-newType-name').value = "";
    document.getElementById('modal-newType-id').value = "";

    if(idType){

        ajax({
            url: urlBase + '/type/' + idType,
            method: 'GET',
            complete: (data) => {
                document.getElementById('modal-newType-name').value = data.name;
                document.getElementById('modal-newType-id').value = data.id;
                modalNewType.toggle();
            },
            error: (err) => {
                console.error(err)
            }
        });

    }else{
        modalNewType.toggle();
    }

}

window.openDeleteTypeModal = (idType) => {

    let name = document.getElementById('modal-deleteType-name');
    let id = document.getElementById('modal-deleteType-id');

    name.innerHTML = "";
    id.value = "";

    ajax({
        url: urlBase + "/type/" + idType,
        method: 'GET',
        complete: (data) => {
            name.innerHTML = data.name;
            id.value = data.id;
            modalDeleteType.toggle();
        }
    });

}

window.onSaveType = (form) => {

    try {
        
        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableTypes();
                modalNewType.toggle()
            },
            error: (err) => {
                errorAlert(err.message);
            }
        });

    } catch (error) {
        console.log(error);
    }

    return false;
}

window.onDeleteType = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableTypes();
            modalDeleteType.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}