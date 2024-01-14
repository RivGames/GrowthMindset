<?php

namespace App\Services;

use App\Azure\Services\TranslatorService;
use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Http\Resources\Quote\QuoteCollection;
use App\Http\Resources\Quote\QuoteResource;
use App\Models\Quote;

class QuoteService
{
    public function __construct(protected TranslatorService $translatorService)
    {
    }

    public function getRandomQuoteMessage(string $languageCode = 'en'): string
    {
        /** @var Quote $quote */
        $quote = Quote::inRandomOrder()->first();

        return sprintf("*%s*\n✍️: %s\n🗂️: %s",
            $this->translatorService->translate($quote->content, $languageCode),
            $this->translatorService->translate($quote->author->full_name, $languageCode),
            $this->translatorService->translate($quote->category->name, $languageCode),
        );
    }

    /**
     * @return \App\Http\Resources\Quote\QuoteCollection
     */
    public function getQuotes(): QuoteCollection
    {
        return new QuoteCollection(Quote::paginate(25));
    }

    /**
     * @param \App\Models\Quote $quote
     * @return \App\Http\Resources\Quote\QuoteResource
     */
    public function getQuote(Quote $quote): QuoteResource
    {
        return new QuoteResource($quote);
    }

    /**
     * @param \App\Http\Requests\Quote\StoreQuoteRequest $request
     * @return \App\Models\Quote
     */
    public function create(StoreQuoteRequest $request): Quote
    {
        return Quote::create($request->validated());
    }

    /**
     * @param \App\Http\Requests\Quote\UpdateQuoteRequest $request
     * @param \App\Models\Quote $quote
     * @return \App\Models\Quote
     */
    public function update(UpdateQuoteRequest $request, Quote $quote): Quote
    {
        $quote->update($request->validated());

        return $quote;
    }

    /**
     * @param \App\Models\Quote $quote
     * @return bool|null
     */
    public function delete(Quote $quote): ?bool
    {
        return $quote->delete();
    }
}