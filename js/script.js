<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seats = document.querySelectorAll('.seat:not(.reserved)');
        const total = document.querySelector('.total-price');
        let totalPrice = 0;

        seats.forEach(function(seat) {
            seat.addEventListener('click', function() {
                if (seat.classList.contains('selected')) {
                    seat.classList.remove('selected');
                    updatePrice(-parseInt(seat.dataset.price));
                } else {
                    seat.classList.add('selected');
                    updatePrice(parseInt(seat.dataset.price));
                }
            });
        });

        function updatePrice(amount) {
            totalPrice += amount;
            total.textContent = `Total Price: $${totalPrice}`;
        }
    });
</script>
