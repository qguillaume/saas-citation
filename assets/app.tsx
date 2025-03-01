import React from 'react';
import ReactDOM from 'react-dom/client';
import Hello from './Hello';

const rootElement = document.getElementById('root');
if (rootElement) {
  const root = ReactDOM.createRoot(rootElement);
  root.render(<Hello />);
}
