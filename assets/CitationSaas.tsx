import React, { useState, useEffect } from 'react';

interface QuoteResponse {
    quote: string;
    isPremium: boolean;
    isAuthenticated: boolean;
}

const CitationSaas: React.FC = () => {
    const [quote, setQuote] = useState<string>('Chargement...');
    const [isPremium, setIsPremium] = useState<boolean>(false);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);

    useEffect(() => {
        const fetchQuote = async () => {
            try {
                const response = await fetch('/api/quote', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    credentials: 'include',
                });

                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }

                const data: QuoteResponse = await response.json();
                setQuote(data.quote);
                setIsPremium(data.isPremium);
                setIsAuthenticated(data.isAuthenticated);
            } catch (error) {
                console.error('Erreur:', error);
                setQuote('Erreur lors du chargement');
            }
        };

        fetchQuote();
    }, []);

    return (
        <div className="container">
            <h1>Citation du Jour</h1>
            <p className="quote">{quote}</p>
            {isAuthenticated ? (
                isPremium ? (
                    <p>Vous êtes un utilisateur Premium !</p>
                ) : (
                    <button
                        className="button"
                        onClick={() => (window.location.href = '/stripe/checkout')}
                    >
                        Devenir Premium
                    </button>
                )
            ) : (
                <p>
                    <a href="/login">Connectez-vous</a> pour devenir Premium !
                </p>
            )}
        </div>
    );
};

export default CitationSaas;