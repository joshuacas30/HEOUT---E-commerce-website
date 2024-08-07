$(document).ready(function() {
    $('#quantity').on('input', function() {
      updateTotalPrice();
    });
  });

  function updateTotalPrice() {
    const quantity = $('#quantity').val();
    const basePrice = 299; // Replace with your base price
    const totalPrice = quantity * basePrice;
    $('#total-price').text(totalPrice);
  }