{\rtf1\ansi\ansicpg1252\cocoartf2821
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 // Detect system's dark/light mode preference\
const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');\
\
// Set initial theme based on system settings\
let currentTheme = mediaQuery.matches ? 'dark' : 'light';\
document.body.classList.add(currentTheme);\
\
// Button to toggle theme manually\
const toggleButton = document.createElement('button');\
toggleButton.textContent = 'Toggle Theme';\
document.body.appendChild(toggleButton);\
\
toggleButton.addEventListener('click', () => \{\
  currentTheme = currentTheme === 'dark' ? 'light' : 'dark';\
  document.body.classList.remove('light', 'dark');\
  document.body.classList.add(currentTheme);\
\});\
\
// Listen for changes in the system preference and update theme\
mediaQuery.addEventListener('change', (e) => \{\
  currentTheme = e.matches ? 'dark' : 'light';\
  document.body.classList.remove('light', 'dark');\
  document.body.classList.add(currentTheme);\
\});\
}