// assets/CitationSaas.tsx

import React, { useState, useEffect } from 'react';
import { Card } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

const CitationSaaS = () => {
  const [quote, setQuote] = useState('');
  const [isPremium, setIsPremium] = useState(false);

  useEffect(() => {
    fetch('/api/quote')
      .then((res) => res.json())
      .then((data) => setQuote(data.quote));
  }, []);

  const handleSubscribe = () => {
    window.location.href = '/stripe/checkout';
  };

  return (
    <div className="p-4 flex flex-col items-center">
      <Card className="max-w-md w-full">
        <h1 className="text-xl font-bold mb-4">Citation du Jour</h1>
        <p className="mb-4">{quote || 'Chargement...'}</p>
        <Button onClick={handleSubscribe} className="w-full">
          Devenir Premium
        </Button>
      </Card>
    </div>
  );
};

export default CitationSaaS;
