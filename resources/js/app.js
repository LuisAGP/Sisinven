import 'flowbite';

window.urlBase = window.location.origin;

window.modalAlert = new Modal(document.getElementById('modal-alert'), {
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {}
});

window.openMenu = () => {
    let sideBar = document.getElementById("default-sidebar");
    sideBar.classList.remove('hide-menu');
    sideBar.classList.add('show-menu');
}

window.closeMenu = () => {
    let sideBar = document.getElementById("default-sidebar");
    sideBar.classList.remove('show-menu');
    sideBar.classList.add('hide-menu');
}

window.ajax = (json) => {

    try {

        fetch(json.url, {
            headers: { 
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
            },
            method: json.method ? json.method : 'POST',
            body: json.body ? json.body : null
        })
        .then(response => response.json())
        .then(data => {
            if(data.code == 200){
                json.success(data)
            }else if(data.code == 500){
                json.error(data)
            }else{
                json.complete(data);
            }
        })
        .catch(err => {
            if(json.catch){
                json.catch(err);
            }
        });
        
    } catch (error) {
        console.error(error);
    }

    return false;

}

// Create our number formatter.
window.moneyFormat = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', });

window.formatDate = (date) => {

    date = date.split('-');
    return date[2] + "/" + date[1] + "/" + date[0];

}

window.errorAlert = (message) => {

    try {

        document.getElementById('modal-alert-icon').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mx-auto mb-4 text-red-400 w-12 h-12">
            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
        </svg>`;
        document.getElementById('modal-alert-message').innerHTML = message;
        modalAlert.toggle();  

    } catch (error) {
        console.error(error);
    }

}


window.successAlert = (message) => {

    try {

        document.getElementById('modal-alert-icon').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mx-auto mb-4 text-green-400 w-12 h-12">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
        </svg>`;
        document.getElementById('modal-alert-message').innerHTML = message;
        modalAlert.toggle();  

    } catch (error) {
        console.error(error);
    }

}

window.updatePagination = (id, data, updater) => {
    
    try {

        data.prev_page_url = data.prev_page_url ? data.prev_page_url.replace(data.path, '') : null;
        data.next_page_url = data.next_page_url ? data.next_page_url.replace(data.path, '') : null;

        let search = "&search=" + document.getElementById(id+'-searcher').value;
        let pagination = document.getElementById(id+'-pagination');
        let prevUrl = data.prev_page_url ? "onclick="+updater+"('"+data.prev_page_url+search+"')" : "";
        let nextUrl = data.next_page_url ? "onclick="+updater+"('"+data.next_page_url+search+"')" : "";

        pagination.innerHTML = `<li>
            <button type="button" ${prevUrl} class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg ${prevUrl && 'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'} dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
            <span class="sr-only">Previous</span>
            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            </button>
        </li>`;
        
        for(let i = 1; i <= data.last_page; i++){

            if(i === data.current_page){
                pagination.innerHTML += `<li>
                    <button type="button" aria-current="page" class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                        ${i}
                    </button>
                </li>`;
            }else{

                pagination.innerHTML += `<li>
                    <button onclick="${updater}('${'?page='+i+search}')" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        ${i}
                    </button>
                </li>`;
            }

        }

        pagination.innerHTML += `<li>
            <button type="button" ${nextUrl} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg ${nextUrl && 'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'} dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
            <span class="sr-only">Next</span>
            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            </button>
        </li>`;

    } catch (error) {
        console.error(error);
    }

}

window.editButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
        </svg>

        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}

window.addButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        </svg>

        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}

window.deleteButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
        </svg>
        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}

window.keyButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 0 0-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 0 0-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 0 0 .75-.75v-1.5h1.5A.75.75 0 0 0 9 19.5V18h1.5a.75.75 0 0 0 .53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1 0 15.75 1.5Zm0 3a.75.75 0 0 0 0 1.5A2.25 2.25 0 0 1 18 8.25a.75.75 0 0 0 1.5 0 3.75 3.75 0 0 0-3.75-3.75Z" clip-rule="evenodd" />
        </svg>
        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}

window.listButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-orange-500 rounded-lg hover:bg-orange-600 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M2.625 6.75a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875 0A.75.75 0 0 1 8.25 6h12a.75.75 0 0 1 0 1.5h-12a.75.75 0 0 1-.75-.75ZM2.625 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0ZM7.5 12a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5h-12A.75.75 0 0 1 7.5 12Zm-4.875 5.25a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875 0a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5h-12a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
        </svg>
        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}

window.cancelButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z" clip-rule="evenodd" />
        </svg>
        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}


window.moneyButton = (text="", callback="") => {

    return `<button 
        type="button"
        onclick="${callback}"
        class="group relative px-1 py-1 text-xs font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 outline-none mr-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        <span class="p-1 pointer-events-none absolute -top-4 bg-black rounded-lg left-4 z-10 w-max opacity-0 transition-opacity group-hover:opacity-100">
            ${text}
        </span>
    </button>`;

}



/************************************** Funciones para el componente dselect **************************************/

window.openOptions = (input) => {

    try {

        let parent = input.parentNode;
        let options = parent.querySelector('[arial-panel="options"]');
        let inputSearch = options.querySelector('[arial-type="search"]');

        options.classList.remove('hidden');
        inputSearch.focus();
        searcOptions(inputSearch);

    } catch (error) {
        console.error(error);
    }

    return false;

}

window.closeOptions = (event) => {

    try {
        
        let input = event.target;
        let target = event.relatedTarget;
        let parent = input.parentNode.parentNode.parentNode;
        let options = parent.querySelector('[arial-panel="options"]');
        
        input.value = "";
        options.classList.add('hidden');

        if (target && "dselect_value" in target.dataset) {

            let text = target.dataset.dselect_text;
            let value = target.dataset.dselect_value;

            let inputText = parent.querySelector('[arial-input="text"]');
            let inputValue = parent.querySelector('[arial-input="value"]');

            inputText.innerHTML = text;
            inputValue.dataset.text = text;
            inputValue.value = value;
            
        }
        
    } catch (error) {
        console.error(error);
    }

    return false;

}

window.searcOptions = (input) => {

    try {
        
        let body = new FormData();
        body.append('search', input.value);

        ajax({
            url: input.dataset.url,
            method: 'POST',
            body: body,
            success: (data) => {
                createOption(input.dataset.id, data.data);
            }
        });

    } catch (error) {
        console.error(error);
    }

    return false;

}

window.createOption = (id, options=[]) => {

    try {

        let ul = document.getElementById(`options-${id}`);
        ul.innerHTML = "";

        for(let option of options){
            ul.innerHTML += `<li>
                <button 
                    data-dselect_text="${option.text}"
                    data-dselect_value="${option.value}"
                    type="button" 
                    class="text-left w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                >${option.text}</button>
            </li>`;
        };

        
    } catch (error) {
        console.error(error);
    }

    return false;

}
