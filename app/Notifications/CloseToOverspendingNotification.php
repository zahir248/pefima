<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CloseToOverspendingNotification extends Notification
{
    use Queueable;

    public $totalExpenses;
    public $thresholdAmount;

    public function __construct($totalExpenses, $thresholdAmount)
    {
        $this->totalExpenses = $totalExpenses;
        $this->thresholdAmount = $thresholdAmount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Warning: Close to Overspending')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your total expenses in the selected category are close to exceeding the budget limit.')
            ->line('Total Expenses: RM ' . number_format($this->totalExpenses, 2))
            ->line('Budget Limit: RM ' . number_format($this->thresholdAmount, 2))
            ->line('You are now at 90% of your budget. Please be cautious of overspending.')
            ->action('View Budget', url('/expensesbudget'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'total_expenses' => $this->totalExpenses,
            'threshold_amount' => $this->thresholdAmount,
        ];
    }
}
