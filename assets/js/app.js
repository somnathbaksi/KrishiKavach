document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide) {
    lucide.createIcons();
  }

  const fakeUpload = document.querySelector('#fakeUpload');
  if (fakeUpload) {
    fakeUpload.addEventListener('click', () => {
      document.querySelector('#frontStatus').textContent = 'front-label.jpg added';
      document.querySelector('#qrStatus').textContent = 'qr-closeup.jpg added';
      document.querySelector('#billStatus').textContent = 'dealer-bill.jpg added';
    });
  }

  const runCheck = document.querySelector('#runCheck');
  if (runCheck) {
    runCheck.addEventListener('click', () => {
      document.querySelector('#riskCard').classList.add('high');
      document.querySelector('#riskTitle').textContent = 'High Risk Product';
      document.querySelector('#riskText').textContent = 'QR code failed, batch sequence is unusual, and label spacing does not match expected packaging. Save evidence and prepare officer review.';
      document.querySelector('#resultBadge').textContent = 'High risk';
      document.querySelector('#resultBadge').className = 'badge red';
      document.querySelector('#resultMeta').textContent = 'Updated just now from sample scan';
      if (window.lucide) {
        lucide.createIcons();
      }
    });
  }
});
