export default function Stats() {
  const stats = [
    { number: "10K+", label: "Khách hàng hài lòng" },
    { number: "500+", label: "Sản phẩm chất lượng" },
    { number: "50+", label: "Thương hiệu uy tín" },
    { number: "99%", label: "Đánh giá tích cực" },
  ]

  return (
    <section className="py-16 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
          {stats.map((stat, index) => (
            <div key={index} className="text-center">
              <div className="text-3xl lg:text-4xl font-bold text-indigo-600 mb-2">{stat.number}</div>
              <div className="text-gray-600 font-medium">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
