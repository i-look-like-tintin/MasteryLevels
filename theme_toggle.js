// JavaScript: Dark/Light mode toggle with localStorage

const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
const themeToggle = document.getElementById('themeToggle');

// Load saved preference or use system setting
let currentTheme = localStorage.getItem('theme') || (mediaQuery.matches ? 'dark' : 'light');
document.body.setAttribute('data-theme', currentTheme);
themeToggle.checked = currentTheme === 'dark';

// Toggle theme on switch
themeToggle.addEventListener('change', () => {
  currentTheme = themeToggle.checked ? 'dark' : 'light';
  document.body.setAttribute('data-theme', currentTheme);
  localStorage.setItem('theme', currentTheme);
});

// Auto update on system theme change
mediaQuery.addEventListener('change', (e) => {
  const systemTheme = e.matches ? 'dark' : 'light';

  // Only auto-update if no manual preference is saved
  if (!localStorage.getItem('theme')) {
    currentTheme = systemTheme;
    document.body.setAttribute('data-theme', currentTheme);
    themeToggle.checked = currentTheme === 'dark';
  }
});
