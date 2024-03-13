import 'flowbite';
import { Modal } from 'flowbite';

document.addEventListener("DOMContentLoaded", function() {
    loadDatatableUsers();
});

window.modalNewUser = new Modal(document.getElementById('modal-newUser'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalSaveUser = new Modal(document.getElementById('modal-saveUser'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalNewPasswordUser = new Modal(document.getElementById('modal-newPasswordUser'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.modalDeleteUser = new Modal(document.getElementById('modal-deleteUser'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.loadDatatableUsers = (complemento="") => {

    let fullUrl = complemento ? urlBase + "/users/" + complemento : urlBase + "/users";

    ajax({
        url: fullUrl,
        method: 'GET',
        complete: (data) => {
            let tbody = document.getElementById('datatableUsers');

            tbody.innerHTML = "";

            for(let i of data.data){
                tbody.innerHTML += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        ${editButton("Editar", "openUserModal("+i.id+")")}
                        ${deleteButton("Eliminar", "openDeleteModal("+i.id+")")}
                        ${keyButton("Cambiar contraseña", "openNewPasswordModal("+i.id+")")}
                    </td> 
                    <td class="px-6 py-4">
                        ${i.username}
                    </td>   
                    <td class="px-6 py-4">
                        ${i.name}
                    </td>
                    <td class="px-6 py-4">
                        ${i.lastname}
                    </td>
                </tr>`;
            }

            updatePagination('datatableUsers' ,data, 'loadDatatableUsers');
        
        },
        error: (err) => {
            console.error(err)
        }
    });

}

document.getElementById('datatableUsers-searcher').addEventListener("keyup", function(e){
    let search = "?search=" + e.target.value
    loadDatatableUsers(search)
});


window.openUserModal = (idUser=null) => {

    let username = document.getElementById('modal-saveUser-username');
    let name = document.getElementById('modal-saveUser-name');
    let lastname = document.getElementById('modal-saveUser-lastname');
    let superuser = document.getElementById('modal-saveUser-superuser');
    let id = document.getElementById('modal-saveUser-id');

    username.innerHTML = "";
    name.value = "";
    lastname.value = "";
    superuser.checked = false;
    id.value = "";

    if(idUser){
        ajax({
            url: urlBase + "/user/" + idUser,
            method: 'GET',
            complete: (data) => {
                username.innerHTML = data.username;
                name.value = data.name;
                lastname.value = data.lastname;
                superuser.checked = data.superuser;
                id.value = data.id;
            }
        });
    }

    modalSaveUser.toggle();

}

window.openNewPasswordModal = (idUser) => {

    let username = document.getElementById('modal-newPasswordUser-username');
    let id = document.getElementById('modal-newPasswordUser-id');
    
    document.getElementById('modal-newPasswordUser-password').value = "";
    document.getElementById('modal-newPasswordUser-password_confirmation').value = ""
    username.innerHTML = "";
    id.value = "";

    if(idUser){
        ajax({
            url: urlBase + "/user/" + idUser,
            method: 'GET',
            complete: (data) => {
                username.innerHTML = data.username;
                id.value = data.id;
            }
        });
    }

    modalNewPasswordUser.toggle();

}

window.openDeleteModal = (idUser) => {

    let username = document.getElementById('modal-deleteUser-username');
    let id = document.getElementById('modal-deleteUser-id');

    username.innerHTML = "";
    id.value = "";

    if(idUser){
        ajax({
            url: urlBase + "/user/" + idUser,
            method: 'GET',
            complete: (data) => {
                username.innerHTML = data.username;
                id.value = data.id;
            }
        });
    }

    modalDeleteUser.toggle();

}

window.onSaveUser = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableUsers();
            if(!modalSaveUser._isHidden){modalSaveUser.toggle();}
            if(!modalNewUser._isHidden){modalNewUser.toggle();}
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;
}

window.onNewPasswordUser = (form) => {

    try {

        ajax({
            url: form.action,
            body: new FormData(form),
            success: (data) => {
                loadDatatableUsers();
                modalNewPasswordUser.toggle();
                successAlert(data.message);
            },
            error: (err) => {
                errorAlert(err.message);
            }
        });
        
    } catch (error) {
        console.log(error)
    }

    return false;

}


window.onDeleteUser = (form) => {

    ajax({
        url: form.action,
        body: new FormData(form),
        success: (data) => {
            loadDatatableUsers();
            if(!modalDeleteUser._isHidden){modalDeleteUser.toggle();}
            successAlert(data.message);
        },
        error: (err) => {
            errorAlert(err.message);
        }
    });

    return false;

}