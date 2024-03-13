import 'flowbite';
import { Modal } from 'flowbite';

document.getElementById('datatableBrands-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value;
    loadDatatableBrands(search);
});

window.modalNewBrand = new Modal(document.getElementById('modal-newBrand'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteBrand = new Modal(document.getElementById('modal-deleteBrand'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableBrands = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/brands/" + complemento : urlBase + "/brands";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableBrands');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openSaveBrandModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteBrandModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.name}
                    </td> 
                </tr>`;
            }

            updatePagination('datatableBrands' ,data, 'loadDatatableBrands');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

window.openSaveBrandModal = (idBrand) => {

    document.getElementById('modal-newBrand-name').value = "";
    document.getElementById('modal-newBrand-id').value = "";

    if(idBrand){

        ajax({
            url: urlBase + '/brand/' + idBrand,
            method: 'GET',
            complete: (data) => {
                document.getElementById('modal-newBrand-name').value = data.name;
                document.getElementById('modal-newBrand-id').value = data.id;
                modalNewBrand.toggle();
            },
            error: (err) => {
                console.error(err)
            }
        });

    }else{
        modalNewBrand.toggle();
    }

}

window.openDeleteBrandModal = (idBrand) => {

    let name = document.getElementById('modal-deleteBrand-name');
    let id = document.getElementById('modal-deleteBrand-id');

    name.innerHTML = "";
    id.value = "";

    ajax({
        url: urlBase + "/brand/" + idBrand,
        method: 'GET',
        complete: (data) => {
            name.innerHTML = data.name;
            id.value = data.id;
            modalDeleteBrand.toggle();
        }
    });

}

window.onSaveBrand = (form) => {

    try {
        
        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableBrands();
                modalNewBrand.toggle()
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

window.onDeleteBrand = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableBrands();
            modalDeleteBrand.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}