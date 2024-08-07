function updatePrice() {
    const quantity = document.getElementById('quantity').value;
    const pricePerUnit = 299; // Replace with your actual price per unit
    const totalPrice = quantity * pricePerUnit;

    document.getElementById('totalPrice').innerText = totalPrice;
  }