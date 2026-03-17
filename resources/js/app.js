import './bootstrap';

function trackClick(key) {
  try {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    navigator.sendBeacon?.(
      '/track/click',
      new Blob([new URLSearchParams({ key, _token: token ?? '' }).toString()], {
        type: 'application/x-www-form-urlencoded;charset=UTF-8',
      }),
    );
  } catch {
    // ignore tracking failures
  }
}

document.addEventListener('click', (e) => {
  const el = e.target?.closest?.('[data-track-click]');
  if (!el) return;
  const key = el.getAttribute('data-track-click');
  if (!key) return;
  trackClick(key);
});
