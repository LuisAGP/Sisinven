import 'flowbite';
import { Modal } from 'flowbite';

document.getElementById('datatableCategories-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value
    loadDatatableCategories(search);
});

window.modalSaveCategory = new Modal(document.getElementById('modal-newCategory'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteCategory = new Modal(document.getElementById('modal-deleteCategory'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableCategories = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/categories/" + complemento : urlBase + "/categories";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableCategories');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton('Editar', "openSaveCategoryModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteCategoryModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.name}
                    </td> 
                </tr>`;
            }

            updatePagination('datatableCategories' ,data, 'loadDatatableCategories');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

window.openSaveCategoryModal = (idCategory=null) => {
    
    document.getElementById('modal-newCategory-name').value = "";
    document.getElementById('modal-newCategory-id').value = "";

    if(idCategory){

        ajax({
            url: urlBase + '/category/' + idCategory,
            method: 'GET',
            complete: (data) => {
                document.getElementById('modal-newCategory-name').value = data.name;
                document.getElementById('modal-newCategory-id').value = data.id;
                modalSaveCategory.toggle();
            },
            error: (err) => {
                console.error(err)
            }
        });

    }else{
        modalSaveCategory.toggle();
    }

}

window.openDeleteCategoryModal = (idCategory) => {

    let name = document.getElementById('modal-deleteCategory-name');
    let id = document.getElementById('modal-deleteCategory-id');

    name.innerHTML = "";
    id.value = "";

    ajax({
        url: urlBase + "/category/" + idCategory,
        method: 'GET',
        complete: (data) => {
            name.innerHTML = data.name;
            id.value = data.id;
            modalDeleteCategory.toggle();
        }
    });

}

window.onSaveCategory = (form) => {

    try {
        
        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableCategories();
                modalSaveCategory.toggle()
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

window.onDeleteCategory = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableCategories();
            modalDeleteCategory.toggle();
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}