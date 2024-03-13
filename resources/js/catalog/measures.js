import 'flowbite';
import { Modal } from 'flowbite';

document.getElementById('datatableMeasures-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value
    loadDatatableMeasures(search);
});

window.modalNewMeasure = new Modal(document.getElementById('modal-newMeasure'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteMeasure = new Modal(document.getElementById('modal-deleteMeasure'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableMeasures = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/measures/" + complemento : urlBase + "/measures";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableMeasures');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openSaveMeasureModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteMeasureModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.value}
                    </td> 
                </tr>`;
            }

            updatePagination('datatableMeasures' ,data, 'loadDatatableMeasures');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

window.openSaveMeasureModal = (idMeasure=null) => {

    document.getElementById('modal-newMeasure-value').value = "";
    document.getElementById('modal-newMeasure-id').value = "";

    if(idMeasure){

        ajax({
            url: urlBase + '/measure/' + idMeasure,
            method: 'GET',
            complete: (data) => {
                document.getElementById('modal-newMeasure-value').value = data.value;
                document.getElementById('modal-newMeasure-id').value = data.id;
                modalNewMeasure.toggle();
            },
            error: (err) => {
                console.error(err)
            }
        });

    }else{
        modalNewMeasure.toggle();
    }

}

window.openDeleteMeasureModal = (idMeasure) => {

    let value = document.getElementById('modal-deleteMeasure-value');
    let id = document.getElementById('modal-deleteMeasure-id');

    value.innerHTML = "";
    id.value = "";

    ajax({
        url: urlBase + "/measure/" + idMeasure,
        method: 'GET',
        complete: (data) => {
            value.innerHTML = data.value;
            id.value = data.id;
            modalDeleteMeasure.toggle();
        }
    });

}

window.onSaveMeasure = (form) => {

    try {
        
        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableMeasures();
                modalNewMeasure.toggle()
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

window.onDeleteMeasure = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableMeasures();
            modalDeleteMeasure.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}