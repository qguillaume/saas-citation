import React from 'react';

interface CardProps {
  children: React.ReactNode;
  className?: string;
}

const Card: React.FC<CardProps> = ({ children, className }) => {
  return (
    <div className={`p-4 border rounded-md shadow-md ${className}`}>
      {children}
    </div>
  );
};

export { Card };
