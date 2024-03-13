import 'flowbite';
import { Modal } from 'flowbite';

document.getElementById('datatableLibrages-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value
    loadDatatableLibrages(search);
});

window.modalNewLibrage = new Modal(document.getElementById('modal-newLibrage'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteLibrage = new Modal(document.getElementById('modal-deleteLibrage'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableLibrages = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/librages/" + complemento : urlBase + "/librages";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableLibrages');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openSaveLibrageModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteLibrageModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.value}
                    </td> 
                </tr>`;
            }

            updatePagination('datatableLibrages' ,data, 'loadDatatableLibrages');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

window.openSaveLibrageModal = (idLibrage) => {
    
    document.getElementById('modal-newLibrage-value').value = "";
    document.getElementById('modal-newLibrage-id').value = "";

    if(idLibrage){

        ajax({
            url: urlBase + '/librage/' + idLibrage,
            method: 'GET',
            complete: (data) => {
                document.getElementById('modal-newLibrage-value').value = data.value;
                document.getElementById('modal-newLibrage-id').value = data.id;
                modalNewLibrage.toggle();
            },
            error: (err) => {
                console.error(err)
            }
        });

    }else{
        modalNewLibrage.toggle();
    }

}

window.openDeleteLibrageModal = (idLibrage) => {

    let value = document.getElementById('modal-deleteLibrage-value');
    let id = document.getElementById('modal-deleteLibrage-id');

    value.innerHTML = "";
    id.value = "";

    ajax({
        url: urlBase + "/librage/" + idLibrage,
        method: 'GET',
        complete: (data) => {
            value.innerHTML = data.value;
            id.value = data.id;
            modalDeleteLibrage.toggle();
        }
    });

}

window.onSaveLibrage = (form) => {

    try {
        
        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableLibrages();
                modalNewLibrage.toggle()
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

window.onDeleteLibrage = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableLibrages();
            modalDeleteLibrage.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}