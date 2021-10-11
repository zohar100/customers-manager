export class UI {
    // Insert given data to table
    loadTableBody (res, tBodyId) {
        tBodyId.html(``);
        res.data ? res.data.map(customer => {
            tBodyId.append(
                `<tr>
                    <td>${customer.id}</td>
                    <td>${customer.name}</td>
                    <td>${customer.type_name}</td>
                    <td>${customer.phone}</td>
                    <td>${customer.email}</td>
                    <td>${customer.address}</td>
                    <td>${customer.gender}</td>
                    <td>${customer.fav_products ? customer.fav_products.map(product => (
                        product.name + ', '
                    )) : null
                    }</td>
                    <td>
                    <img src="${customer.image}" style="width: 150px"/>
                    </td>
                    <td>
                        <button class="btn btn-danger delete-btn" data-id=${customer.id}>Delete</button>
                    </td>
                </tr>`
            )
        }) : tBodyId.append(`<tr><td colspan="10" style="text-align:center;">${res.message}</td></tr>`);
    }

    //load product/types cards
    loadItems (data, itemElement) {
        let renderHtml = ``;
        data ? data.forEach(item => {
        renderHtml += `<div class="mt-2 col">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <div class="card-title h5" id="i${item.id}">${item.name}</div>
                                    <button class="btn btn-danger delete-btn" data-id=${item.id} >Delete</button>
                                    <button type="button" class="btn btn-primary edit-btn" data-name=${item.name.replace(' ', '+')} data-id=${item.id}>Edit</button>
                                </div>
                            </div>
                        </div>`
        }) : null;
        itemElement.html(renderHtml);
    }

    // Set loading component
    setLoading (bool) {
        if(bool) {
            $.get("../../src/components/spinner.html", (data) => {
                $('body').append(data);
            })
        }else{
            $('.spinner').remove();
        }
    }

    //Load form product`s data
    loadFormProducts (data, prodElement) {
        data ? data.forEach(product => {
            prodElement.append(
                `<div class="form-check form-check-inline">
                    <input name="fav_products" type="checkbox" class="form-check-input" value="${product.id}">
                    <label title="" class="form-check-label">${product.name}</label>
                </div>`
            )
        }) : null;
    }

    //Load form product`s data
    loadFormTypes (data, typeElement) {
        data ? data.forEach(type => {
            typeElement.append(
                `<option value="${type.id}">${type.name}</option>`
            )
        }) : null;
    }

    popUpMessage (type, message) {
        if(type === 'fail'){
            $('#messages').append(`
            <div class="alert alert-danger m-2" role="alert">
                ${message}
            </div>
            `)
        }else{
            $('#messages').append(`
            <div class="alert alert-success m-2" role="alert">
                ${message}
            </div>
            `)
        }

        setTimeout(() => {
            this.clearMessages();
        }, 2500);

    }

    clearMessages () {
        $('#messages').html('');
    }
};