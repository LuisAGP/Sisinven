import 'flowbite';
import { Modal } from 'flowbite';

document.getElementById('datatableMaterials-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value
    loadDatatableMaterials(search);
});

window.modalNewMaterial = new Modal(document.getElementById('modal-newMaterial'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteMaterial = new Modal(document.getElementById('modal-deleteMaterial'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableMaterials = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/materials/" + complemento : urlBase + "/materials";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableMaterials');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openSaveMaterialModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteMaterialModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.name}
                    </td> 
                </tr>`;
            }

            updatePagination('datatableMaterials' ,data, 'loadDatatableMaterials');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

window.openSaveMaterialModal = (idMaterial=null) => {

    document.getElementById('modal-newMaterial-name').value = "";
    document.getElementById('modal-newMaterial-id').value = "";

    if(idMaterial){

        ajax({
            url: urlBase + '/material/' + idMaterial,
            method: 'GET',
            complete: (data) => {
                document.getElementById('modal-newMaterial-name').value = data.name;
                document.getElementById('modal-newMaterial-id').value = data.id;
                modalNewMaterial.toggle();
            },
            error: (err) => {
                console.error(err)
            }
        });

    }else{
        modalNewMaterial.toggle();
    }

}

window.openDeleteMaterialModal = (idMaterial) => {

    let name = document.getElementById('modal-deleteMaterial-name');
    let id = document.getElementById('modal-deleteMaterial-id');

    name.innerHTML = "";
    id.value = "";

    ajax({
        url: urlBase + "/material/" + idMaterial,
        method: 'GET',
        complete: (data) => {
            name.innerHTML = data.name;
            id.value = data.id;
            modalDeleteMaterial.toggle();
        }
    });

}

window.onSaveMaterial = (form) => {

    try {
        
        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableMaterials();
                modalNewMaterial.toggle();
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

window.onDeleteMaterial = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableMaterials();
            modalDeleteMaterial.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}