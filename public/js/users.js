let countOfUsers = 6;
function more()
{
    countOfUsers += 6;
    users();
}
function fails(data)
{
    if (data.total_users < data.count)
    {
        let fails = "";
        let failList = Object.values(data.fails);
        failList.map(failed => {
            fails += `<p class="text-white">${failed}</p>`;
        });
        cardList.innerHTML = `<div>
                    <span class="text-white">${data.message}</span>
                    <br />
                    ${fails}
                </div>`;
    }
    else{
        cardList.innerHTML = `<span class="text-white">${data.message}</span>`;
    }
}
async function users()
{
    await fetch(`/api/v1/users?count=${parseInt(countOfUsers)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success)
            {
                cardList.innerHTML = ``;
                data.users.map(user => {
                    cardList.innerHTML += `
                    <div class="d-flex justify-content-center align-items-center card bg-dark" style="width: 18rem;">
                        <img class="card-img-top mt-3" src="${user.photo}" alt="${user.name}">
                        <div class="d-flex flex-column card-body text-white">
                            <span>Name: ${user.name}</span>
                            <span>Email: ${user.email}</span>
                            <span>Phone: ${user.phone}</span>
                            <span>Position: ${user.position}</span>
                        </div>
                    </div>
                `;
                });
                if (data.total_users < countOfUsers || data.total_users < data.count)
                {
                    if (document.querySelector(`#more`) !== null) document.querySelector(`#more`).remove();
                }else{
                    cardList.innerHTML += `
                    <div class="container">
                        <button type="button" class="btn btn-success" id="more" onclick="more()">Show More</button>
                    </div>
                    `;
                }
            }
            else
            {
                if (document.querySelector(`#more`) !== null) document.querySelector(`#more`).remove();
            }
        });
}
$(() => {
    users()
});
