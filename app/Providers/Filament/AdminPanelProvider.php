<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\AdvokatResource;
use App\Filament\Resources\ManajerResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->brandLogo(asset('img/logo_pena.png'))
            ->favicon(asset('favicon.png')) // Path to your favicon
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->sidebarCollapsibleOnDesktop()
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                'Tenaga Ahli',
                'Pengaturan',
                'Profile'
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->setNavigationLabel('My Profile')
                    ->setNavigationGroup('Pengaturan')
                    ->setIcon('heroicon-o-user'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->userMenuItems([
                MenuItem::make()
                    ->label('My Profile')
                    ->url(fn(): string => '/admin/my-profile')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $user = Filament::auth()->user();

                $navigationGroups = [];

                // Common navigation items
                $navigationGroups[] = NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Dashboard')
                            ->icon('heroicon-o-home')
                            ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard'))
                            ->url(fn(): string => Dashboard::getUrl()),
                    ]);

                $navigationGroups[] = NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Data Aduan')
                            ->icon('heroicon-o-book-open')
                            ->isActiveWhen(fn(): bool => request()->routeIs(
                                'filament.admin.resources.aduans.index',
                                'filament.admin.resources.aduans.create',
                                'filament.admin.resources.aduans.view',
                                'filament.admin.resources.aduans.edit',
                                'filament.admin.resources.aduans.delete'
                            ))
                            ->url(fn(): string => '/admin/aduans'),
                    ]);

                $navigationGroups[] = NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Data Pelapor')
                            ->icon('heroicon-o-identification')
                            ->isActiveWhen(fn(): bool => request()->routeIs(
                                'filament.admin.resources.pelapors.index',
                                'filament.admin.resources.pelapors.create',
                                'filament.admin.resources.pelapors.view',
                                'filament.admin.resources.pelapors.edit',
                                'filament.admin.resources.pelapors.delete'
                            ))
                            ->url(fn(): string => '/admin/pelapors'),
                    ]);

                $navigationGroups[] = NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Data Korban')
                            ->icon('heroicon-o-circle-stack')
                            ->isActiveWhen(fn(): bool => request()->routeIs(
                                'filament.admin.resources.korbans.index',
                                'filament.admin.resources.korbans.create',
                                'filament.admin.resources.korbans.view',
                                'filament.admin.resources.korbans.edit',
                                'filament.admin.resources.korbans.delete'
                            ))
                            ->url(fn(): string => '/admin/korbans'),
                    ]);

                $navigationGroups[] = NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Data Terlapor')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->isActiveWhen(fn(): bool => request()->routeIs(
                                'filament.admin.resources.terlapors.index',
                                'filament.admin.resources.terlapors.create',
                                'filament.admin.resources.terlapors.view',
                                'filament.admin.resources.terlapors.edit',
                                'filament.admin.resources.terlapors.delete'
                            ))
                            ->url(fn(): string => '/admin/terlapors'),
                    ]);

                if ($user->hasRole('admin')) {
                    $navigationGroups[] = NavigationGroup::make('Jenis Kasus dan Layanan')->items([
                        NavigationItem::make('Jenis Kasus')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->isActiveWhen(fn(): bool => request()->routeIs(
                                'filament.admin.resources.jenis_kasuses.index',
                                'filament.admin.resources.jenis_kasuses.view',
                                'filament.admin.resources.jenis_kasuses.edit'
                            ))
                            ->url(fn(): string => '/admin/jenis-kasuses'),
                        NavigationItem::make('Layanan')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->isActiveWhen(fn(): bool => request()->routeIs(
                                'filament.admin.resources.layanans.index',
                                'filament.admin.resources.layanans.view',
                                'filament.admin.resources.layanans.edit'
                            ))
                            ->url(fn(): string => '/admin/layanans'),
                    ]);

                    $navigationGroups[] = NavigationGroup::make('Tenaga Ahli')->items(array_merge(
                        ManajerResource::getNavigationItems(),
                        [
                            NavigationItem::make('Advokat')
                                ->icon('heroicon-o-check-badge')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.advokats.index',
                                    'filament.admin.resources.advokats.create',
                                    'filament.admin.resources.advokats.view',
                                    'filament.admin.resources.advokats.delete',
                                    'filament.admin.resources.advokats.edit'
                                ))
                                ->url(fn(): string => '/admin/advokats'),
                            NavigationItem::make('Pekerja Sosial')
                                ->icon('heroicon-o-check-badge')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.peksos.index',
                                    'filament.admin.resources.peksos.create',
                                    'filament.admin.resources.peksos.view',
                                    'filament.admin.resources.peksos.delete',
                                    'filament.admin.resources.peksos.edit'
                                ))
                                ->url(fn(): string => '/admin/peksos'),
                            NavigationItem::make('Psikolog')
                                ->icon('heroicon-o-check-badge')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.psikolog.index',
                                    'filament.admin.resources.psikolog.create',
                                    'filament.admin.resources.psikolog.view',
                                    'filament.admin.resources.psikolog.delete',
                                    'filament.admin.resources.psikolog.edit'
                                ))
                                ->url(fn(): string => '/admin/psikologs'),
                            NavigationItem::make('Konselor')
                                ->icon('heroicon-o-check-badge')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.konselors.index',
                                    'filament.admin.resources.konselors.create',
                                    'filament.admin.resources.konselors.view',
                                    'filament.admin.resources.konselors.edit'
                                ))
                                ->url(fn(): string => '/admin/konselors'),
                            NavigationItem::make('Paralegal')
                                ->icon('heroicon-o-check-badge')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.paralegals.index',
                                    'filament.admin.resources.paralegals.create',
                                    'filament.admin.resources.paralegals.view',
                                    'filament.admin.resources.paralegals.delete',
                                    'filament.admin.resources.paralegals.edit'
                                ))
                                ->url(fn(): string => '/admin/paralegals'),
                        ]
                    ));
                }

                // Conditional 'Pengaturan' group
                if ($user->hasRole('admin')) {
                    $navigationGroups[] = NavigationGroup::make('Pengaturan')
                        ->items([
                            NavigationItem::make('Users')
                                ->icon('heroicon-o-users')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.users.index',
                                    'filament.admin.resources.users.create',
                                    'filament.admin.resources.users.view',
                                    'filament.admin.resources.users.edit'
                                ))
                                ->url(fn(): string => UserResource::getUrl('index')),
                            NavigationItem::make('Roles')
                                ->icon('heroicon-o-lock-closed')
                                ->isActiveWhen(fn(): bool => request()->routeIs(
                                    'filament.admin.resources.roles.index',
                                    'filament.admin.resources.roles.create',
                                    'filament.admin.resources.roles.view',
                                    'filament.admin.resources.roles.edit'
                                ))
                                ->url(fn(): string => '/admin/shield/roles'),
                        ]);
                }

                return $builder->groups($navigationGroups);
            })
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
