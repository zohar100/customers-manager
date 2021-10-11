export class Api {
    baseUrl = 'http://localhost:8000';

    async get(url) {
        let recivedData;
        await $.ajax({
            type: 'GET',
            url: this.baseUrl + url,
            success: (data) => {
                recivedData = data;
            },
            error: () => {
                recivedData = false;
            }
        })
        return recivedData;
    }

    async post(url, data){
        let recivedData;
        await $.ajax({
            type:"POST",
            url: this.baseUrl + url,
            data: data,
            ContentType:"application/json",
            success:(res) => {
                recivedData = res;
            },
            error:(res) => {
                recivedData = res;
            }

        });
        return recivedData;
    }

    async delete(url, data){
        let recivedData;
        await $.ajax({
            type:"DELETE",
            url: this.baseUrl + url,
            data: data,
            ContentType:"application/json",
            success:(res) => {
                recivedData = res;
            },
            error:(res) => {
                recivedData = res;
            }

        });
        return recivedData;
    }

    async put(url, data){
        let recivedData;
        await $.ajax({
            type:"PUT",
            url: this.baseUrl + url,
            data: data,
            ContentType:"application/json",
            success:(res) => {
                recivedData = res;
            },
            error:(res) => {
                recivedData = res;
            }

        });
        return recivedData;
    }
};