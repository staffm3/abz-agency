async function positions()
{
    await fetch(`/api/v1/positions`)
        .then(response => response.json())
        .then(data => {
            cardList.innerHTML = ``;
            console.log(data);
            if (data.success)
                data.positions.map(position => {
                    cardList.innerHTML += `
                    <div class="d-flex justify-content-center align-items-center card bg-dark" style="width: 18rem;">
                        <div class="d-flex flex-column card-body text-white">
                            <span>Position ID: ${position.id}</span>
                            <span>Position: ${position.name}</span>
                        </div>
                    </div>
                `;
                });
            else
            {
                cardList.innerHTML = `<span class="text-white">${data.message}</span>`;
            }
        });
}
$(() => {
    positions()
});
