function validateNominal(input) {
    // Hapus karakter non-digit dan batasi ke 9 digit
    let value = input.value.replace(/\D/g, '').slice(0, 9);
    input.value = value;
  }
  