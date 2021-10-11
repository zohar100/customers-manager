import { Api } from '../Api.js';
import { UI } from '../UI.js';
import { getFormValuesAndValidate } from '../utilities/getFormValuesAndValidate.js';

const api = new Api();
const ui = new UI();

//Form rules
const rules = {
    name: {
        required: true
    }
}
// Current state is products or types
let isProducts = true;

//Show products or types
function productsOrTypes () {
    ui.setLoading(true);
    // Check if product link has class active
    if($('#productsLink').hasClass('active')) {
        $('#formLabel').text('Add Product');
        $('#formButton').text('Add Product');
        // Feth products
        const response = api.get('/api/products/read.php');
        response.then((res) => {
            if(res.data){
                // Display products
                ui.loadItems(res.data, $("#items"));
                ui.setLoading(false);
            }
        })
        isProducts = true;
    // If product hasn`t class active
    }else{
        $('#formLabel').text('Add Type');
        $('#formButton').text('Add Type');
        // Fetch types
        const response = api.get('/api/types/read.php');
        response.then((res) => {
            if(res.data){
                // Display types
                ui.loadItems(res.data, $("#items"));
                ui.setLoading(false);
            }
        })
        isProducts = false;
    }
}

$(document).ready(() => {
    // Get links
    const productsLink = $('#productsLink');
    const typesLink = $('#typesLink');

    // If products/types render products/types
    productsOrTypes(productsLink);

    productsLink.on('click',() => {
        if(!productsLink.hasClass('active')){
            typesLink.removeClass('active');
            productsLink.addClass('active');
            productsOrTypes();
        }
    });

    typesLink.on('click',() => {
        if(!typesLink.hasClass('active')){
            productsLink.removeClass('active');
            typesLink.addClass('active');
            productsOrTypes();
        }
    })

    //Add Product/Type
    $('#dashboardForm').submit((e) => {
        e.preventDefault();

        const [values, valid] = getFormValuesAndValidate($('#dashboardForm :input'), rules)

        if(valid){
            if(isProducts) {
                // If current state is products
                const response = api.post('/api/products/create.php', JSON.stringify(values));
                response.then((res) => {
                    if(res.status){
                        productsOrTypes();
                        ui.popUpMessage('success', res.message)
                    }else{
                        ui.popUpMessage('fail', res.message)
                    }
                })
            }else {
                //If current state is types
                const response = api.post('/api/types/create.php', JSON.stringify(values));
                response.then((res) => {
                    if(res.status){
                        productsOrTypes();
                        ui.popUpMessage('success', res.message)
                    }else{
                        ui.popUpMessage('fail', res.message)
                    }
                })
            }
        }
    });

    // Delete Product/Type
    $('#items').click((e) => {
        if(e.target.classList.contains('delete-btn')){
            if(isProducts) {
                // If current state is products
                const response = api.delete('/api/products/delete.php', JSON.stringify({
                    id: e.target.dataset.id
                }));
                response.then((data) => {
                    if(data.status){
                        productsOrTypes();
                        ui.popUpMessage('success', data.message);
                    }else {
                        ui.popUpMessage('fail', data.message);
                    }
                });
            }else{
                //If current state is types
                const response = api.delete('/api/types/delete.php', JSON.stringify({
                    id: e.target.dataset.id
                }));
                response.then((data) => {
                    if(data.status){
                        productsOrTypes();
                        ui.popUpMessage('success', data.message);
                    }else {
                        ui.popUpMessage('fail', data.message);
                    }
                });
            }
        }
    });

    let showForm = false;
    // Edit Product/Type
    $('#items').click((e) => {
        // Show Edit Form or Item Name
        if(e.target.classList.contains('edit-btn')){
            showForm = !showForm;
            let itemName = e.target.dataset.name.replace('+', ' ');
            let itemId = e.target.dataset.id;
            let element = $('#i'+itemId);

            if(showForm) {
                element.html(`
               <form id="editForm" method="post">
                    <div class="mb-3">
                    <input name="name" placeholder="${itemName}" type="text" class="form-control">
                    <input name="id" value="${itemId}" type="hidden" class="form-control">
                    </div>
                </form>
               `)
            }else{
                element.html(itemName);
            }
        }

        // On Submit form
        $('#editForm').submit((e) => {
            e.preventDefault();
            console.log($('#editForm :input'));
            const [values, valid] = getFormValuesAndValidate($('#editForm :input'), rules);
            console.log(values);
            if(valid){
                if(isProducts) {
                    // If current state is products
                    const response = api.put('/api/products/update.php', JSON.stringify(values));
                    response.then((res) => {
                        if(res.status){
                            ui.popUpMessage('success', res.message)
                            productsOrTypes();
                        }else{
                            ui.popUpMessage('fail', res.message)
                        }
                    })
                }else {
                    //If current state is types
                    const response = api.put('/api/types/update.php', JSON.stringify(values));
                    response.then((res) => {
                        if(res.status){
                            ui.popUpMessage('success', res.message)
                            productsOrTypes();
                        }else{
                            ui.popUpMessage('fail', res.message)
                        }
                    })
                }
            }
        })
        
    });
    
});