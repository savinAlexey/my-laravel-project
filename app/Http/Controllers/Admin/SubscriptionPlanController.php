<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        // Получаем все планы подписок с платформами
        $plans = SubscriptionPlan::with('platform')->get();
        return view('livewire.admin.settings.subscription-plans.index', compact('plans'));
    }

    public function create()
    {
        // Получаем все платформы для отображения в списке
        return view('livewire.admin.settings.subscription-plans.create');
    }

    // Метод для общих операций по созданию и обновлению подписки
    protected function saveSubscriptionPlan(Request $request, SubscriptionPlan $subscriptionPlan = null)
    {
        if (!$subscriptionPlan) {
            // Если подписка не передана (для метода создания), создаем новую
            $subscriptionPlan = new SubscriptionPlan();
        }

        // Применяем данные из запроса
        $subscriptionPlan->name = $request->name;
        // Убираем код подписки
        $subscriptionPlan->price = $request->price;
        $subscriptionPlan->currency = $request->currency;
        $subscriptionPlan->description = $request->description;
        $subscriptionPlan->period = $request->period;
        $subscriptionPlan->platform_id = $request->platform_id;  // Используем platform_id для связи с платформой

        // Вычисляем дату окончания подписки
        $subscriptionPlan->end_date = Carbon::now()->addDays($request->period);

        // Сохраняем подписку
        $subscriptionPlan->save();

        return $subscriptionPlan;
    }

    // Метод для создания подписки
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'period' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'platform_id' => 'required|exists:platforms,id',  // Платформа обязана существовать в таблице платформ
        ]);

        // Используем общий метод для сохранения подписки
        $this->saveSubscriptionPlan($request);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'План подписки успешно создан');
    }

    // Метод для обновления подписки
    public function update(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string|max:1000',
            'period' => 'required|integer|min:1',
            'platform_id' => 'required|exists:platforms,id',  // Платформа обязана существовать в таблице платформ
        ]);

        // Используем общий метод для обновления подписки
        $this->saveSubscriptionPlan($request, $plan);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'План подписки успешно обновлён');
    }

    // Метод для редактирования подписки
    public function edit(SubscriptionPlan $plan)
    {
        $platforms = Platform::all(); // Получаем все платформы
        return view('livewire.admin.settings.subscription-plans.edit', compact('plan', 'platforms'));
    }

    // Метод для удаления подписки
    public function destroy(SubscriptionPlan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Подписка удалена');
    }
}

