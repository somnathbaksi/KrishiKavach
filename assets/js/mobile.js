document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide) {
    lucide.createIcons();
  }

  document.querySelectorAll('.otp-grid input').forEach((input, index, inputs) => {
    input.addEventListener('input', () => {
      input.value = input.value.replace(/\D/g, '').slice(0, 1);
      if (input.value && inputs[index + 1]) {
        inputs[index + 1].focus();
      }
    });
  });

  const uploadButton = document.querySelector('[data-upload-demo]');
  if (uploadButton) {
    uploadButton.addEventListener('click', () => {
      document.querySelector('[data-front-status]').textContent = document.documentElement.lang === 'hi' ? 'फ्रंट फोटो जोड़ा' : 'front-label.jpg';
      document.querySelector('[data-qr-status]').textContent = document.documentElement.lang === 'hi' ? 'QR फोटो जोड़ा' : 'qr-closeup.jpg';
      document.querySelector('[data-bill-status]').textContent = document.documentElement.lang === 'hi' ? 'बिल जोड़ा' : 'dealer-bill.jpg';
    });
  }

  const runCheck = document.querySelector('[data-run-check]');
  if (runCheck) {
    runCheck.addEventListener('click', () => {
      const risk = document.querySelector('[data-risk]');
      risk.classList.add('high');
      const isHindi = document.documentElement.lang === 'hi';
      document.querySelector('[data-risk-title]').textContent = isHindi ? 'उच्च जोखिम उत्पाद' : 'High Risk Product';
      document.querySelector('[data-risk-text]').textContent = isHindi ? 'QR कोड विफल है और बैच नंबर असामान्य है। सबूत सुरक्षित रखें और अधिकारी समीक्षा तैयार करें।' : 'QR code failed and batch number format is unusual. Save evidence and prepare officer review.';
      document.querySelector('[data-risk-badge]').textContent = isHindi ? 'उच्च जोखिम' : 'High risk';
      document.querySelector('[data-risk-badge]').className = 'badge red';
      if (window.lucide) {
        lucide.createIcons();
      }
    });
  }

  const latInput = document.querySelector('#latitude');
  const lngInput = document.querySelector('#longitude');
  const accuracyInput = document.querySelector('#location_accuracy');
  const geoStatus = document.querySelector('#geoStatus');
  if (latInput && lngInput && navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        latInput.value = position.coords.latitude.toFixed(7);
        lngInput.value = position.coords.longitude.toFixed(7);
        if (accuracyInput) {
          accuracyInput.value = position.coords.accuracy.toFixed(2);
        }
        if (geoStatus) {
          geoStatus.textContent = document.documentElement.lang === 'hi'
            ? `लोकेशन सेव: ${latInput.value}, ${lngInput.value}`
            : `Location saved: ${latInput.value}, ${lngInput.value}`;
        }
      },
      () => {
        if (geoStatus) {
          geoStatus.textContent = document.documentElement.lang === 'hi'
            ? 'लोकेशन अनुमति नहीं मिली। स्कैन फिर भी सेव होगा।'
            : 'Location permission unavailable. Scan will still be saved.';
        }
      },
      { enableHighAccuracy: true, timeout: 8000, maximumAge: 60000 }
    );
  }
});
