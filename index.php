<?php

abstract class UIComponent {
    protected $props;
    protected $child;

    public function __construct(array $props = [], $child = null) {
        $this->props = $props;
        $this->child = $child;
    }

    abstract public function render();
}


class UIText extends UIComponent {
    public function render() {
        $text = $this->props['text'] ?? 'Default Text';
        $class = $this->props['class'] ?? 'text-lg text-gray-800';
        $id = $this->props['id'] ?? '';
        return "<span id='{$id}' class='{$class}'>{$text}</span>";
    }
}

class UIButton extends UIComponent {
    public function render() {
        $text = $this->props['text'] ?? 'Click me';
        $onClick = $this->props['onClick'] ?? '';
        $class = $this->props['class'] ?? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all';
        $icon = $this->props['icon'] ?? '';
        $iconHtml = $icon ? "<i class='{$icon} mr-2'></i>" : '';
        return "<button class='{$class}' onclick='{$onClick}'>{$iconHtml}{$text}</button>";
    }
}

class UIColumn extends UIComponent {
    public function render() {
        $children = $this->props['children'] ?? [];
        $class = $this->props['class'] ?? 'flex flex-col gap-4';
        $id = $this->props['id'] ?? '';
        $childHtml = '';
        foreach ($children as $child) {
            if ($child instanceof UIComponent) {
                $childHtml .= $child->render();
            } elseif (is_string($child)) {
                $childHtml .= $child;
            } else {
                $childHtml .= "<div class='text-red-500'>Error: Invalid child component</div>";
            }
        }
        return "<div id='{$id}' class='{$class}'>{$childHtml}</div>";
    }
}


class CategoryPill extends UIComponent {
    public function render() {
        $text = $this->props['text'] ?? 'Category';
        $active = $this->props['active'] ?? false;
        $class = $active 
            ? 'category-button px-4 py-2 rounded-full bg-indigo-600 text-white font-medium text-sm shadow-md' 
            : 'category-button px-4 py-2 rounded-full bg-white text-gray-700 font-medium text-sm shadow-md hover:bg-gray-50';
        // เพิ่ม window. เพื่อให้เรียกใช้ JavaScript function จาก global scope ได้
        return "<button class='{$class}' onclick='window.filterByCategory(\"{$text}\")'>{$text}</button>";
    }
}

class FoodItem extends UIComponent {
    public function render() {
        if (!isset($this->props['name'])) {
            return "<div class='text-red-500'>Error: FoodItem name is required</div>";
        }
        $name = $this->props['name'];
        $price = $this->props['price'] ?? '0.00';
        $description = $this->props['description'] ?? 'No description available';
        $image = $this->props['image'] ?? 'https://picsum.photos/300/200';
        $category = $this->props['category'] ?? 'food';
        return "
        <div class='food-item' data-category='{$category}'>
            <div class='bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1'>
                <div class='h-40 bg-gray-200 relative overflow-hidden'>
                    <img src='{$image}' alt='{$name}' class='w-full h-full object-cover'>
                    <div class='absolute top-3 right-3 bg-indigo-600 text-white px-2 py-1 rounded-lg text-sm font-bold'>
                        ฿{$price}
                    </div>
                </div>
                <div class='p-4'>
                    <h3 class='text-lg font-bold text-gray-800 mb-1'>{$name}</h3>
                    <p class='text-gray-600 text-sm h-10 overflow-hidden'>{$description}</p>
                    <div class='mt-4 flex justify-between items-center'>
                        <span class='text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded'>{$category}</span>
                        <button class='bg-indigo-600 text-white font-medium py-1 px-3 rounded-lg hover:bg-indigo-700 transition-all flex items-center' 
                                onclick='window.addToCart(\"{$name}\", \"{$price}\")'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6v6m0 0v6m0-6h6m-6 0H6' />
                            </svg>
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
        </div>";
    }
}


class AppBar extends UIComponent {
    public function render() {
        $title = $this->props['title'] ?? 'Food App';
        $logo = $this->props['logo'] ?? '🍔';
        return "
        <div class='w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-4 px-6 flex justify-between items-center shadow-md sticky top-0 z-50'>
            <div class='flex items-center gap-2'>
                <span class='text-2xl'>{$logo}</span>
                <span class='text-xl font-bold'>{$title}</span>
            </div>
            <div class='hidden md:flex items-center gap-6'>
                <button class='text-white hover:text-blue-200 flex items-center' onclick='window.showPage(\"home\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' />
                    </svg>
                    หน้าแรก
                </button>
                <button class='text-white hover:text-blue-200 flex items-center' onclick='window.showPage(\"cart\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z' />
                    </svg>
                    ตะกร้า (<span id='cart-count'>0</span>)
                </button>
                <button class='text-white hover:text-blue-200 flex items-center' onclick='window.showPage(\"profile\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' />
                    </svg>
                    โปรไฟล์
                </button>
            </div>
            <button class='md:hidden text-white' onclick='window.toggleMobileMenu()'>
                <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6h16M4 12h16M4 18h16' />
                </svg>
            </button>
        </div>
        <div id='mobile-menu' class='hidden md:hidden fixed inset-0 bg-indigo-800 bg-opacity-95 z-50 flex flex-col items-center justify-center'>
            <button class='absolute top-4 right-4 text-white' onclick='window.toggleMobileMenu()'>
                <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                </svg>
            </button>
            <div class='flex flex-col items-center gap-8'>
                <button class='text-white text-xl flex items-center' onclick='window.showMobilePage(\"home\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 mr-2' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' />
                    </svg>
                    หน้าแรก
                </button>
                <button class='text-white text-xl flex items-center' onclick='window.showMobilePage(\"cart\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 mr-2' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z' />
                    </svg>
                    ตะกร้า (<span id='mobile-cart-count'>0</span>)
                </button>
                <button class='text-white text-xl flex items-center' onclick='window.showMobilePage(\"profile\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 mr-2' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' />
                    </svg>
                    โปรไฟล์
                </button>
            </div>
        </div>";
    }
}

class FloatingActionButton extends UIComponent {
    public function render() {
        $onClick = $this->props['onClick'] ?? '';
        $icon = $this->props['icon'] ?? '+';
        $text = $this->props['text'] ?? '';
        return "
        <button class='fixed bottom-6 right-6 bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-3 px-6 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 z-30' onclick='{$onClick}'>
            <span class='text-xl mr-1'>{$icon}</span>
            {$text}
        </button>";
    }
}


class Modal extends UIComponent {
    public function render() {
        $title = $this->props['title'] ?? 'Modal';
        $content = $this->props['content'] ?? 'Content goes here';
        $buttons = $this->props['buttons'] ?? '';
        return "
        <div id='myModal' class='hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50'>
            <div class='bg-white p-6 rounded-xl shadow-2xl max-w-md w-full transform transition-all'>
                <div class='flex justify-between items-center mb-4'>
                    <h2 class='text-xl font-bold text-gray-800'>{$title}</h2>
                    <button class='text-gray-500 hover:text-gray-700' onclick='window.hideModal()'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                        </svg>
                    </button>
                </div>
                <div class='mb-6 text-gray-600'>{$content}</div>
                <div class='flex justify-end gap-3'>
                    {$buttons}
                    <button class='bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg hover:bg-gray-300 transition-all' onclick='window.hideModal()'>ปิด</button>
                </div>
            </div>
        </div>";
    }
}

class CartItems extends UIComponent {
    public function render() {
        return "
        <div class='bg-white p-6 rounded-xl shadow-md'>
            <div id='cart-empty' class='text-center text-gray-500 py-6'>
                <svg xmlns='http://www.w3.org/2000/svg' class='h-16 w-16 mx-auto mb-4 text-gray-300' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z' />
                </svg>
                <p>ตะกร้าของคุณว่างเปล่า</p>
                <button class='mt-4 text-indigo-600 hover:text-indigo-800 font-medium' onclick='window.showPage(\"home\")'>กลับไปเลือกซื้ออาหาร</button>
            </div>
            <div id='cart-items-container' class='hidden'>
                <h3 class='text-lg font-bold text-gray-800 mb-4'>รายการอาหารในตะกร้า</h3>
                <ul id='cart-items' class='divide-y'></ul>
                <div class='mt-6 pt-4 border-t'>
                    <div class='flex justify-between items-center mb-2'>
                        <span class='text-gray-600'>ราคารวม:</span>
                        <span class='text-xl font-bold text-gray-800' id='cart-total'>฿0.00</span>
                    </div>
                </div>
            </div>
        </div>";
    }
}

class SearchBar extends UIComponent {
    public function render() {
        return "
        <div class='relative'>
            <input type='text' id='searchInput' placeholder='ค้นหาอาหาร...' onkeyup='window.searchFood()' 
                   class='w-full py-3 px-4 pl-12 rounded-full bg-white shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500'>
            <div class='absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400'>
                <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z' />
                </svg>
            </div>
        </div>";
    }
}

class UserProfile extends UIComponent {
    public function render() {
        $name = $this->props['name'] ?? 'สมชาย สบายดี';
        $email = $this->props['email'] ?? 'somchai@example.com';
        $phone = $this->props['phone'] ?? '099-999-9999';
        return "
        <div class='bg-white rounded-xl shadow-md overflow-hidden'>
            <div class='p-8 bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-center'>
                <div class='w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center text-indigo-600 text-4xl font-bold mb-4'>
                    " . substr($name, 0, 1) . "
                </div>
                <h2 class='text-2xl font-bold'>{$name}</h2>
                <p class='text-indigo-100'>สมาชิกทั่วไป</p>
            </div>
            <div class='p-6'>
                <div class='mb-6'>
                    <h3 class='text-lg font-bold text-gray-800 mb-4'>ข้อมูลส่วนตัว</h3>
                    <div class='flex items-center gap-3 mb-3'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' />
                        </svg>
                        <span class='text-gray-600'>{$email}</span>
                    </div>
                    <div class='flex items-center gap-3'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z' />
                        </svg>
                        <span class='text-gray-600'>{$phone}</span>
                    </div>
                </div>
                <h3 class='text-lg font-bold text-gray-800 mb-4'>การตั้งค่า</h3>
                <div class='space-y-3'>
                    <button class='w-full flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-gray-100'>
                        <div class='flex items-center gap-3'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' />
                            </svg>
                            <span>แก้ไขโปรไฟล์</span>
                        </div>
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5l7 7-7 7' />
                        </svg>
                    </button>
                    <button class='w-full flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-gray-100'>
                        <div class='flex items-center gap-3'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9' />
                            </svg>
                            <span>การแจ้งเตือน</span>
                        </div>
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5l7 7-7 7' />
                        </svg>
                    </button>
                    <button class='w-full flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-gray-100'>
                        <div class='flex items-center gap-3'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z' />
                            </svg>
                            <span>วิธีการชำระเงิน</span>
                        </div>
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5l7 7-7 7' />
                        </svg>
                    </button>
                </div>
                <button class='mt-6 w-full bg-red-500 text-white font-medium py-3 px-4 rounded-lg hover:bg-red-600 transition-all flex justify-center items-center' onclick='alert(\"Logged out!\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-2' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1' />
                    </svg>
                    ออกจากระบบ
                </button>
            </div>
        </div>";
    }
}


class App {
    private static function startPage() {
        echo "<!DOCTYPE html>";
        echo "<html lang='th'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Food Delivery App</title>";
        echo "<script src='https://cdn.tailwindcss.com'></script>";
        echo "<link href='https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap' rel='stylesheet'>";
        echo "<style>
            body { font-family: 'Prompt', sans-serif; background-color: #f7f9fc; }
            .fade-in { animation: fadeIn 0.3s ease-in-out; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            .grid-food-items { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
            .no-scrollbar::-webkit-scrollbar { display: none; }
        </style>";
        echo "</head>";
        echo "<body class='min-h-screen'>";
    }

    private static function endPage() {
        echo <<<EOT
        <script>
            // Define global variables and functions
            window.cart = [];
            window.currentPage = 'home';
    
            window.addToCart = function(item, price) {
                const existingItemIndex = window.cart.findIndex(cartItem => cartItem.name === item);
                if (existingItemIndex !== -1) {
                    window.cart[existingItemIndex].quantity++;
                } else {
                    window.cart.push({ name: item, price: parseFloat(price), quantity: 1 });
                }
                window.showNotification(`เพิ่ม \${item} ลงในตะกร้าแล้ว!`);
                window.updateCart();
            };
    
            window.removeFromCart = function(index) {
                const itemName = window.cart[index].name;
                window.cart.splice(index, 1);
                window.showNotification(`ลบ \${itemName} ออกจากตะกร้าแล้ว`);
                window.updateCart();
            };
    
            window.updateCartQuantity = function(index, change) {
                window.cart[index].quantity += change;
                if (window.cart[index].quantity <= 0) {
                    window.removeFromCart(index);
                    return;
                }
                window.updateCart();
            };
    
            window.updateCart = function() {
                const cartCount = document.getElementById('cart-count');
                const mobileCartCount = document.getElementById('mobile-cart-count');
                const totalItems = window.cart.reduce((sum, item) => sum + item.quantity, 0);
                if (cartCount) cartCount.textContent = totalItems;
                if (mobileCartCount) mobileCartCount.textContent = totalItems;
    
                const cartItems = document.getElementById('cart-items');
                const cartEmptyMessage = document.getElementById('cart-empty');
                const cartItemsContainer = document.getElementById('cart-items-container');
                const cartTotal = document.getElementById('cart-total');
    
                if (window.cart.length > 0) {
                    if (cartEmptyMessage) cartEmptyMessage.classList.add('hidden');
                    if (cartItemsContainer) cartItemsContainer.classList.remove('hidden');
                    const total = window.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    if (cartTotal) cartTotal.textContent = `฿\${total.toFixed(2)}`;
                    if (cartItems) {
                        cartItems.innerHTML = window.cart.map((item, index) => `
                            <li class='py-4 flex justify-between items-center'>
                                <div>
                                    <div class='font-medium'>\${item.name}</div>
                                    <div class='text-gray-500'>฿\${item.price.toFixed(2)}</div>
                                </div>
                                <div class='flex items-center gap-3'>
                                    <div class='flex items-center border rounded-lg overflow-hidden'>
                                        <button class='px-2 py-1 bg-gray-100 hover:bg-gray-200' 
                                                onclick='window.updateCartQuantity(\${index}, -1)'>-</button>
                                        <span class='px-3'>\${item.quantity}</span>
                                        <button class='px-2 py-1 bg-gray-100 hover:bg-gray-200' 
                                                onclick='window.updateCartQuantity(\${index}, 1)'>+</button>
                                    </div>
                                    <button class='text-red-500 hover:text-red-700' onclick='window.removeFromCart(\${index})'>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />
                                        </svg>
                                    </button>
                                </div>
                            </li>
                        `).join('');
                    }
                } else {
                    if (cartEmptyMessage) cartEmptyMessage.classList.remove('hidden');
                    if (cartItemsContainer) cartItemsContainer.classList.add('hidden');
                }
            };
    
            window.showModal = function() {
                const modal = document.getElementById('myModal');
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('fade-in');
                }
            };
    
            window.hideModal = function() {
                const modal = document.getElementById('myModal');
                if (modal) modal.classList.add('hidden');
            };
    
            window.toggleMobileMenu = function() {
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) mobileMenu.classList.toggle('hidden');
            };
    
            window.showMobilePage = function(page) {
                window.toggleMobileMenu();
                window.showPage(page);
            };
    
            window.showPage = function(page) {
                const pages = ['home-page', 'cart-page', 'profile-page'];
                pages.forEach(p => {
                    const element = document.getElementById(p);
                    if (element) {
                        if (p === page + '-page') {
                            element.classList.remove('hidden');
                            element.classList.add('fade-in');
                        } else {
                            element.classList.add('hidden');
                        }
                    }
                });
            };
    
            window.showNotification = function(message) {
                console.log(message); // Placeholder for notification system
            };
    
            window.searchFood = function() {
                const input = document.getElementById('searchInput').value.toLowerCase();
                const items = document.querySelectorAll('.food-item');
                items.forEach(item => {
                    const name = item.querySelector('h3').textContent.toLowerCase();
                    item.style.display = name.includes(input) ? '' : 'none';
                });
            };
    
            window.filterByCategory = function(category) {
                const items = document.querySelectorAll('.food-item');
                const buttons = document.querySelectorAll('.category-button');
                buttons.forEach(btn => {
                    if (btn.textContent === category) {
                        btn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
                        btn.classList.add('bg-indigo-600', 'text-white');
                    } else {
                        btn.classList.remove('bg-indigo-600', 'text-white');
                        btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
                    }
                });
                items.forEach(item => {
                    const itemCategory = item.dataset.category;
                    item.style.display = (category === 'ทั้งหมด' || itemCategory === category) ? '' : 'none';
                });
            };
    
            // Initialize cart on page load
            window.addEventListener('load', function() {
                window.updateCart();
            });
        </script>
        </body>
        </html>
    EOT;
    }

    private static function getFoodItems() {
        return [
            ['name' => 'ข้าวผัดกระเพราหมูกรอบ', 'price' => '89', 'description' => 'กระเพราหมูกรอบใส่ไข่ดาว รสชาติจัดจ้าน', 'image' => 'https://img.wongnai.com/p/1920x0/2021/01/17/c95146b336274b0283b92b6943d289d8.jpg', 'category' => 'อาหารไทย'],
            ['name' => 'ผัดไทยกุ้งสด', 'price' => '95', 'description' => 'ผัดไทยรสชาติดั้งเดิม กุ้งตัวใหญ่', 'image' => 'https://www.unileverfoodsolutions.co.th/dam/global-ufs/mcos/SEA/calcmenu/recipes/TH-recipes/pasta-dishes/%E0%B8%9C%E0%B8%B1%E0%B8%94%E0%B9%84%E0%B8%97%E0%B8%A2%E0%B8%81%E0%B8%B8%E0%B9%89%E0%B8%87%E0%B8%AA%E0%B8%94/%E0%B8%9C%E0%B8%B1%E0%B8%94%E0%B9%84%E0%B8%97%E0%B8%A2%E0%B8%81%E0%B8%B8%E0%B9%89%E0%B8%87%E0%B8%AA%E0%B8%94_header.jpg', 'category' => 'อาหารไทย'],
            ['name' => 'เบอร์เกอร์เนื้อชีส', 'price' => '159', 'description' => 'เบอร์เกอร์เนื้อสองชั้นกับชีสละลาย', 'image' => 'https://www.unileverfoodsolutions.co.th/dam/global-ufs/mcos/SEA/calcmenu/recipes/TH-recipes/red-meats-&-red-meat-dishes/%E0%B8%8A%E0%B8%B5%E0%B8%AA%E0%B9%80%E0%B8%9A%E0%B8%AD%E0%B8%A3%E0%B9%8C%E0%B9%80%E0%B8%81%E0%B8%AD%E0%B8%A3%E0%B9%8C/%E0%B8%8A%E0%B8%B5%E0%B8%AA%E0%B9%80%E0%B8%9A%E0%B8%AD%E0%B8%A3%E0%B9%8C%E0%B9%80%E0%B8%81%E0%B8%AD%E0%B8%A3%E0%B9%8C_header.jpg', 'category' => 'ฟาสต์ฟู้ด'],
            ['name' => 'พิซซ่าฮาวายเอียน', 'price' => '249', 'description' => 'พิซซ่าแฮมสับกับสับปะรด', 'image' => 'https://1376delivery.com/productimages/614_Hawaiian-.jpg', 'category' => 'ฟาสต์ฟู้ด'],
            ['name' => 'ต้มยำกุ้งน้ำข้น', 'price' => '150', 'description' => 'ต้มยำกุ้งรสจัดเข้มข้น', 'image' => 'https://www.jmthaifood.com/wp-content/uploads/2020/01/%E0%B8%95%E0%B9%89%E0%B8%A1%E0%B8%A2%E0%B8%B3%E0%B8%81%E0%B8%B8%E0%B9%89%E0%B8%87-1.jpg', 'category' => 'อาหารไทย'],
            ['name' => 'ชาไทยเย็น', 'price' => '45', 'description' => 'ชาไทยรสเข้มข้น หวานมัน', 'image' => 'https://www.aromathailand.com/wp-content/uploads/2023/09/Cover-Thai-tea.jpg', 'category' => 'เครื่องดื่ม'],
            ['name' => 'มัทฉะลาเต้', 'price' => '55', 'description' => 'มัทฉะลาเต้รสชาเข้ม', 'image' => 'https://matchazuki.com/wp-content/uploads/2017/09/Matcha-Coffee.jpg', 'category' => 'เครื่องดื่ม'],
            ['name' => 'ข้าวเหนียวมะม่วง', 'price' => '79', 'description' => 'ข้าวเหนียวกับมะม่วงสุก', 'image' => 'https://www.ofm.co.th/blog/wp-content/uploads/2022/04/%E0%B8%82%E0%B9%89%E0%B8%B2%E0%B8%A7%E0%B9%80%E0%B8%AB%E0%B8%99%E0%B8%B5%E0%B8%A2%E0%B8%A7%E0%B8%A1%E0%B8%B0%E0%B8%A1%E0%B9%88%E0%B8%A7%E0%B8%87-1.jpg', 'category' => 'ของหวาน'],
        ];
    }

    private static function renderApp() {
        session_start();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        
        $categories = [
            new CategoryPill(['text' => 'ทั้งหมด', 'active' => true]),
            new CategoryPill(['text' => 'อาหารไทย']),
            new CategoryPill(['text' => 'ฟาสต์ฟู้ด']),
            new CategoryPill(['text' => 'เครื่องดื่ม']),
            new CategoryPill(['text' => 'ของหวาน']),
        ];

        $foodItems = array_map(fn($item) => new FoodItem($item), self::getFoodItems());

        $homePage = new UIColumn([
            'id' => 'home-page',
            'class' => 'flex flex-col gap-6',
            'children' => [
                new SearchBar(),
                new UIColumn([
                    'class' => 'flex overflow-x-auto py-2 gap-3 no-scrollbar',
                    'children' => $categories
                ]),
                new UIText(['text' => 'เมนูยอดนิยม', 'class' => 'text-2xl font-bold text-gray-800 mt-2']),
                new UIColumn([
                    'class' => 'grid-food-items',
                    'children' => $foodItems
                ]),
                new FloatingActionButton([
                    'onClick' => 'window.showModal()', 
                    'icon' => '🛒', 
                    'text' => 'ดูตะกร้า'
                ]),
                new Modal([
                    'title' => 'สั่งอาหารด่วน', 
                    'content' => 'เลือกเพิ่มอาหารโปรดของคุณอีกไหม?',
                    'buttons' => '<button class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700 transition-all" onclick="window.showPage(\'cart\'); window.hideModal();">ไปที่ตะกร้า</button>'
                ])
            ]
        ]);

        $cartPage = new UIColumn([
            'id' => 'cart-page',
            'class' => 'hidden flex flex-col gap-6',
            'children' => [
                new UIText(['text' => 'ตะกร้าของฉัน', 'class' => 'text-2xl font-bold text-gray-800']),
                new CartItems(),
                new UIColumn([
                    'class' => 'mt-4',
                    'children' => [
                        new UIButton([
                            'text' => 'ชำระเงิน', 
                            'onClick' => 'alert(\"กำลังดำเนินการชำระเงิน...\")',
                            'class' => 'w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all'
                        ])
                    ]
                ])
            ]
        ]);

        $profilePage = new UIColumn([
            'id' => 'profile-page',
            'class' => 'hidden flex flex-col gap-6',
            'children' => [
                new UserProfile([
                    'name' => 'สมชาย สบายดี',
                    'email' => 'somchai@example.com',
                    'phone' => '099-999-9999'
                ])
            ]
        ]);

        
        $appStructure = new UIColumn([
            'class' => 'bg-gray-100 min-h-screen flex flex-col',
            'children' => [
                new AppBar(['title' => 'อร่อยเดลิเวอรี่', 'logo' => '🍜']),
                new UIColumn([
                    'class' => 'flex-1 p-4 md:p-6 max-w-5xl mx-auto w-full',
                    'children' => [$homePage, $cartPage, $profilePage]
                ])
            ]
        ]);

        self::startPage();
        echo $appStructure->render();
        self::endPage();
    }
    
    public static function run() {
        self::renderApp();
    }
}


App::run();
?>