"use client"

import { useState } from "react"
import Link from "next/link"
import { Search, ShoppingBag, Menu, X, User } from "lucide-react"
import { Button } from "@/components/ui/button"

export default function Header() {
  const [isMenuOpen, setIsMenuOpen] = useState(false)

  return (
    <header className="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link href="/" className="flex items-center space-x-2">
            <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
              <span className="text-white font-bold text-lg">J</span>
            </div>
            <span className="font-serif font-bold text-xl text-gray-900">BanQuanJeans</span>
          </Link>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center space-x-8">
            <Link href="/products" className="text-gray-700 hover:text-indigo-600 font-medium transition-colors">
              Sản phẩm
            </Link>
            <Link href="/categories" className="text-gray-700 hover:text-indigo-600 font-medium transition-colors">
              Danh mục
            </Link>
            <Link href="/about" className="text-gray-700 hover:text-indigo-600 font-medium transition-colors">
              Về chúng tôi
            </Link>
            <Link href="/contact" className="text-gray-700 hover:text-indigo-600 font-medium transition-colors">
              Liên hệ
            </Link>
          </nav>

          {/* Search and Actions */}
          <div className="flex items-center space-x-4">
            <div className="hidden sm:flex items-center bg-gray-100 rounded-lg px-3 py-2 max-w-xs">
              <Search className="w-4 h-4 text-gray-500 mr-2" />
              <input
                type="text"
                placeholder="Tìm kiếm..."
                className="bg-transparent border-none outline-none text-sm flex-1"
              />
            </div>

            <Button variant="ghost" size="sm" className="hidden sm:flex">
              <User className="w-5 h-5" />
            </Button>

            <Button variant="ghost" size="sm" className="relative">
              <ShoppingBag className="w-5 h-5" />
              <span className="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                2
              </span>
            </Button>

            {/* Mobile menu button */}
            <Button variant="ghost" size="sm" className="md:hidden" onClick={() => setIsMenuOpen(!isMenuOpen)}>
              {isMenuOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
            </Button>
          </div>
        </div>

        {/* Mobile Navigation */}
        {isMenuOpen && (
          <div className="md:hidden border-t border-gray-200 py-4">
            <div className="flex flex-col space-y-4">
              <div className="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                <Search className="w-4 h-4 text-gray-500 mr-2" />
                <input
                  type="text"
                  placeholder="Tìm kiếm..."
                  className="bg-transparent border-none outline-none text-sm flex-1"
                />
              </div>
              <Link href="/products" className="text-gray-700 hover:text-indigo-600 font-medium">
                Sản phẩm
              </Link>
              <Link href="/categories" className="text-gray-700 hover:text-indigo-600 font-medium">
                Danh mục
              </Link>
              <Link href="/about" className="text-gray-700 hover:text-indigo-600 font-medium">
                Về chúng tôi
              </Link>
              <Link href="/contact" className="text-gray-700 hover:text-indigo-600 font-medium">
                Liên hệ
              </Link>
            </div>
          </div>
        )}
      </div>
    </header>
  )
}
