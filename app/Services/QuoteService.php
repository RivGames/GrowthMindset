<?php

namespace App\Services;

use App\Azure\Services\TranslatorService;
use App\DTOs\Quote\StoreQuoteDTO;
use App\Enums\LanguageCode;
use App\Models\Quote;
use Spatie\LaravelData\PaginatedDataCollection;

class QuoteService
{
    public function __construct(protected TranslatorService $translatorService) {}

    public function getRandomQuoteMessage(string $languageCode = 'en'): string
    {
        /** @var Quote $quote */
        $quote = Quote::query()->inRandomOrder()->first();

        $text = $quote->content;
        $authorName = $quote->author->full_name ?? '👤';
        $categoryName = $quote->category->name;

        if (LanguageCode::isTranslationable($languageCode)) {
            $authorName = $this->translatorService->translate($authorName, $languageCode);
            $categoryName = $this->translatorService->translate($categoryName, $languageCode);
            if ($quote->category_id !== 12) {
                $text = $quote->author?->full_name . ' said* ' . $quote->content;
                $text = $this->translatorService->translate($text, $languageCode);
                $text = str_replace('*', '', substr($text, (int)strpos($text, '*') + 2));
            } else {
                $text = $this->translatorService->translate($text, $languageCode);
            }
        }

        return sprintf("*%s*\n✍️: %s\n🗂️: %s", $text, $authorName, $categoryName);
    }

    /**
     * @return PaginatedDataCollection
     */
    public function getQuotes(): PaginatedDataCollection
    {
        return StoreQuoteDTO::collection(Quote::query()->paginate(25));
    }

    /**
     * @param Quote $quote
     * @return StoreQuoteDTO
     */
    public function getQuote(Quote $quote): StoreQuoteDTO
    {
        return StoreQuoteDTO::from($quote);
    }
}
