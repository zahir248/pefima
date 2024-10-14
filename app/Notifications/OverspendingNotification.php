<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OverspendingNotification extends Notification
{
    use Queueable;

    public $totalExpenses;
    public $budgetLimit;

    public function __construct($totalExpenses, $budgetLimit)
    {
        $this->totalExpenses = $totalExpenses;
        $this->budgetLimit = $budgetLimit;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Warning: You Have Overspent Your Budget')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your total expenses in the selected category have exceeded the budget limit.')
            ->line('Total Expenses: RM ' . number_format($this->totalExpenses, 2))
            ->line('Budget Limit: RM ' . number_format($this->budgetLimit, 2))
            ->line('Please review your expenses and take appropriate action.')
            ->action('View Budget', url('/expensesbudget'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'total_expenses' => $this->totalExpenses,
            'budget_limit' => $this->budgetLimit,
        ];
    }
}
