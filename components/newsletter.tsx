import { Button } from "@/components/ui/button"
import { Mail } from "lucide-react"

export default function Newsletter() {
  return (
    <section className="py-20 bg-indigo-600">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <div className="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-6">
            <Mail className="w-8 h-8 text-white" />
          </div>

          <h2 className="font-serif text-3xl lg:text-4xl font-bold text-white mb-4">Đăng Ký Nhận Tin Tức</h2>

          <p className="text-lg text-indigo-100 mb-8 max-w-2xl mx-auto">
            Nhận thông tin về sản phẩm mới, khuyến mãi đặc biệt và xu hướng thời trang jeans mới nhất
          </p>

          <div className="max-w-md mx-auto">
            <div className="flex flex-col sm:flex-row gap-4">
              <input
                type="email"
                placeholder="Nhập email của bạn"
                className="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-white focus:ring-opacity-50 outline-none"
              />
              <Button size="lg" className="bg-white text-indigo-600 hover:bg-gray-100">
                Đăng ký
              </Button>
            </div>

            <p className="text-sm text-indigo-200 mt-4">Chúng tôi cam kết bảo mật thông tin của bạn và không spam</p>
          </div>
        </div>
      </div>
    </section>
  )
}
