import { Star } from "lucide-react"

export default function Testimonials() {
  const testimonials = [
    {
      name: "Nguyễn Minh Anh",
      role: "Khách hàng thân thiết",
      content: "Chất lượng quần jeans tuyệt vời, form dáng đẹp và rất bền. Tôi đã mua nhiều chiếc và luôn hài lòng.",
      rating: 5,
      avatar: "/vietnamese-woman-portrait.png",
    },
    {
      name: "Trần Văn Hùng",
      role: "Doanh nhân",
      content: "Dịch vụ chăm sóc khách hàng tuyệt vời, giao hàng nhanh. Sản phẩm đúng như mô tả và chất lượng cao.",
      rating: 5,
      avatar: "/vietnamese-man-portrait.png",
    },
    {
      name: "Lê Thị Mai",
      role: "Sinh viên",
      content: "Giá cả hợp lý, thiết kế trẻ trung và hiện đại. Rất phù hợp với sinh viên như tôi.",
      rating: 5,
      avatar: "/young-vietnamese-woman-portrait.png",
    },
  ]

  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            Khách Hàng Nói Gì Về Chúng Tôi
          </h2>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            Hàng nghìn khách hàng đã tin tưởng và lựa chọn sản phẩm của chúng tôi
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-8">
          {testimonials.map((testimonial, index) => (
            <div key={index} className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
              <div className="flex items-center mb-4">
                {[...Array(testimonial.rating)].map((_, i) => (
                  <Star key={i} className="w-5 h-5 text-yellow-400 fill-current" />
                ))}
              </div>

              <p className="text-gray-600 mb-6 leading-relaxed">"{testimonial.content}"</p>

              <div className="flex items-center">
                <img
                  src={testimonial.avatar || "/placeholder.svg"}
                  alt={testimonial.name}
                  className="w-12 h-12 rounded-full mr-4"
                />
                <div>
                  <h4 className="font-semibold text-gray-900">{testimonial.name}</h4>
                  <p className="text-sm text-gray-500">{testimonial.role}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
