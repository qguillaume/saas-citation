import React, { useState, useEffect } from 'react';

interface QuoteResponse {
    quote: string;
    isPremium: boolean;
    isAuthenticated: boolean;
    premiumQuote?: string; // Citation spéciale pour les membres Premium
}

const CitationSaas: React.FC = () => {
    const [quote, setQuote] = useState<string>('Chargement...');
    const [premiumQuote, setPremiumQuote] = useState<string | null>(null);
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
                if (data.isPremium && data.premiumQuote) {
                    setPremiumQuote(data.premiumQuote);
                }
            } catch (error) {
                console.error('Erreur:', error);
                setQuote('Connectez-vous pour découvrir une nouvelle citation chaque jour !');
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
                    <>
                        <p>Vous êtes un utilisateur Premium !</p>
                        {premiumQuote && (
                            <div className="premium-quote"
                            style={{
                                marginTop: '20px',
                                padding: '15px',
                                backgroundColor: '#fffbcc',
                                borderLeft: '5px solid #ffc107',
                                borderRadius: '5px',
                            }}
                            >
                                <h2>Citation Secrète pour Premium :</h2>
                                <p>{premiumQuote}</p>
                            </div>
                        )}
                    </>
                ) : (
                    <button
                        className="button"
                        onClick={() => (window.location.href = '/stripe/checkout')}
                    >
                        Devenez Premium pour accéder à des citations exclusives !
                    </button>
                )
            ) : (
                <p>
                    <a href="/login">Connectez-vous</a>
                </p>
            )}
        </div>
    );
};

export default CitationSaas;
